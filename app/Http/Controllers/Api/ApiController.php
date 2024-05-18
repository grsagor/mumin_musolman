<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotificationJob;
use App\Mail\Otp;
use App\Models\AmolVideo;
use App\Models\Channel;
use App\Models\ChannelSubscriber;
use App\Models\CustomAd;
use App\Models\DeviceToken;
use App\Models\LiveChannel;
use App\Models\Message;
use App\Models\PremiumAmolVideo;
use App\Models\PremiumVideo;
use App\Models\RegularAmolVideo;
use App\Models\Setting;
use App\Models\Tafsir;
use App\Models\TransactionHistory;
use App\Models\User;
use Carbon\Carbon;
use Helper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    /* Auth Start */
    public function register(Request $request)
    {
        $rule = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'password' => 'required',
            'profile_image' => 'required|image|mimes:jpg,png|max:2048'
        ];

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            $data['status'] = 0;
            $data['data'] = $validator->errors();
            return response()->json($data, 422);
        }

        $user = User::where('email', $request->email)->first();
        if ($user && $user->is_verified) {
            $data['status'] = 0;
            $data['data'] = "A user is registered with this email.";
            return response()->json($data, 422);
        } elseif ($user && !$user->is_verified) {
            $user->delete();
        }
        $user = User::where('phone', $request->phone)->first();
        if ($user && $user->is_verified) {
            $data['status'] = 0;
            $data['data'] = "A user is registered with this phone.";
            return response()->json($data, 422);
        } elseif ($user && !$user->is_verified) {
            $user->delete();
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->dob = $request->dob;
        $user->password = Hash::make($request->password);
        $user->visible_password = $request->password;
        $user->status = 1;
        $otp = rand(1000, 9999);
        $user->otp = $otp;
        $user->otp_expired_at = Carbon::now()->addMinutes(2);
        $user->is_verified = 0;
        Helper::updateFileField($request, $user, 'profile_image', 'uploads/user-images/');

        $body = 'Your One time password is ' . $otp . '. Do not share your one time password to anyone.';
        $subject = 'Registration OTP.';

        Mail::to($request->email)->send(new Otp($body, $subject));

        if ($user->save()) {
            $data['status'] = 1;
            $data['data'] = $user;
            $data['token'] = $this->generateToken($user);
            return response()->json($data, 200);
        } else {
            $data['status'] = 0;
            $data['data'] = 'Something went wrong during registering user.';
            return response()->json($data, 200);
        }
    }
    public function verifyOtp(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $currentDateTime = Carbon::now();
                $otp_expired_at = Carbon::parse($user->otp_expired_at);
                if ($otp_expired_at->lt($currentDateTime)) {
                    $data['status'] = 0;
                    $data['data'] = 'OTP expired.';
                    return response()->json($data, 200);
                } else {
                    if ($user->otp == $request->otp) {
                        $user->is_verified = 1;
                        $user->save();
                    } else {
                        $data['status'] = 0;
                        $data['data'] = 'OTP does not matched.';
                        return response()->json($data, 200);
                    }
                }
            } else {
                $data['status'] = 0;
                $data['data'] = 'No user found.';
                return response()->json($data, 200);
            }

            DB::commit();

            $data['status'] = 1;
            $data['data'] = $user;
            return response()->json($data, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $data['status'] = 0;
            $data['data'] = $e->getMessage();
            return response()->json($data, 200);
        }
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $data['status'] = 0;
            $data['data'] = $validator->errors();
            return response()->json($data, 400); // Bad Request
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $response = [
                    'status' => 1,
                    'token' => $this->generateToken($user),
                    'data' => $user
                ];
                return response()->json($response, 200); // OK

            } else {
                $response = [
                    'status' => 0,
                    'data' => "Credentials don't matched."
                ];
                return response()->json($response, 401); // Unauthorized
            }
        } else {
            $response = [
                'status' => 0,
                'data' => "No user found."
            ];
            return response()->json($response, 404); // Not Found
        }
    }
    private function generateToken($user)
    {
        $token = Str::random(60);
        $user->token = $token;
        $user->save();
        return $token;
    }
    public function updateUser(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $fillableFields = ['name', 'email', 'phone', 'address'];
            foreach ($fillableFields as $field) {
                if ($request->filled($field)) {
                    $user->$field = $request->$field;
                }
            }

            Helper::updateFileField($request, $user, 'profile_image', 'uploads/user-images/');

            if ($user->save()) {
                $data['status'] = 1;
                $data['data'] = $user;
                return response()->json($data, 200);
            } else {
                $data['status'] = 0;
                $data['data'] = "Can't update.";
                return response()->json($data, 200);
            }
        } else {
            $data['status'] = 0;
            $data['data'] = "User not found.";
            return response()->json($data, 200);
        }
    }
    public function getUserDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            $data['status'] = 0;
            $data['data'] = $validator->errors();
            return response()->json($data, 400); // Bad Request
        }

        $user = User::find($request->user_id);

        if ($user) {
            $response = [
                'status' => 1,
                'data' => $user
            ];
            return response()->json($response, 200); // OK
        } else {
            $response = [
                'status' => 0,
                'data' => "No user found."
            ];
            return response()->json($response, 404); // Not Found
        }
    }
    public function storeDeviceToken(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request->id) {
                $device_token = DeviceToken::where('user_id', $request->id)->first();
                if (!$device_token) {
                    $device_token = new DeviceToken();
                }
            }
            if (!$request->id) {
                $device_token = new DeviceToken();
            }
            $device_token->user_id = $request->id;
            $device_token->device_token = $request->device_token;
            $device_token->save();
            $data['status'] = 1;
            $data['data'] = $device_token;
            DB::commit();
            return response()->json($data, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $data['status'] = 0;
            $data['data'] = $e->getMessage();
            return response()->json($data, 500);
        }
    }
    /* Auth End */

    public function getRegularFreeVideoList()
    {
        $data = RegularAmolVideo::orderByDesc('created_at')->get();
        $response = [
            "status" => 1,
            "data" => $data
        ];
        return response()->json($response, 200);
    }
    public function getRegularFreeVideoDetails(Request $request)
    {
        $data = RegularAmolVideo::find($request->id);
        $response = [
            "status" => 1,
            "data" => $data
        ];
        return response()->json($response, 200);
    }



    public function getAmolVideoList()
    {
        $data = AmolVideo::orderByDesc('created_at')->get();
        $response = [
            "status" => 1,
            "data" => $data
        ];
        return response()->json($response, 200);
    }
    public function getAmolVideoDetails(Request $request)
    {
        $data = AmolVideo::find($request->id);
        $response = [
            "status" => 1,
            "data" => $data
        ];
        return response()->json($response, 200);
    }



    public function getPremiumAmolVideoList()
    {
        $data = PremiumAmolVideo::orderByDesc('created_at')->get();
        $response = [
            "status" => 1,
            "data" => $data
        ];
        return response()->json($response, 200);
    }
    public function getPremiumAmolVideoDetails(Request $request)
    {
        $data = PremiumAmolVideo::find($request->id);
        $response = [
            "status" => 1,
            "data" => $data
        ];
        return response()->json($response, 200);
    }




    public function getPremiumVideoList()
    {
        $data = PremiumVideo::orderByDesc('created_at')->get();
        $response = [
            "status" => 1,
            "data" => $data
        ];
        return response()->json($response, 200);
    }
    public function getPremiumVideoDetails(Request $request)
    {
        $data = PremiumVideo::find($request->id);
        $response = [
            "status" => 1,
            "data" => $data
        ];
        return response()->json($response, 200);
    }




    public function getLiveChannelList()
    {
        $data = LiveChannel::orderByDesc('created_at')->get();
        $response = [
            "status" => 1,
            "data" => $data
        ];
        return response()->json($response, 200);
    }
    public function getLiveChannelDetails(Request $request)
    {
        $data = LiveChannel::find($request->id);
        $response = [
            "status" => 1,
            "data" => $data
        ];
        return response()->json($response, 200);
    }





    public function getTafsirList()
    {
        $data = Tafsir::orderByDesc('created_at')->get();
        $response = [
            "status" => 1,
            "data" => $data
        ];
        return response()->json($response, 200);
    }
    public function getTafsirDetails(Request $request)
    {
        $data = Tafsir::find($request->id);
        $response = [
            "status" => 1,
            "data" => $data
        ];
        return response()->json($response, 200);
    }




    public function getCustomAdList() {
        $data = CustomAd::orderByDesc('created_at')->get();
        $response = [
            "status" => 1,
            "data" => $data
        ];
        return response()->json($response, 200);
    }
    public function getCustomAdDetails(Request $request)
    {
        $data = CustomAd::find($request->id);
        $response = [
            "status" => 1,
            "data" => $data
        ];
        return response()->json($response, 200);
    }




    public function storePayment(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = User::find($request->user_id);

            $wallet = $user->wallet + $request->amount;

            if ($request->for) {
                if ($request->for == "chat") {
                    $wallet = $wallet - Helper::getSettings('message_charge');
                    if (!$user->chat_expiry_date) {
                        $user->chat_expiry_date = Carbon::now()->addDays(Helper::getSettings('message_validity'));
                    } else {
                        $currentDateTime = Carbon::now();
                        $chat_expiry_date = Carbon::parse($user->chat_expiry_date);
                        if ($chat_expiry_date->lt($currentDateTime)) {
                            $chat_expiry_date = $currentDateTime->copy()->addDays(Helper::getSettings('message_validity'));
                        } else {
                            $chat_expiry_date->addDays(Helper::getSettings('message_validity'));
                        }
                        $user->chat_expiry_date = $chat_expiry_date;
                    }
                } elseif ($request->for == "premium") {
                    $wallet = $wallet - Helper::getSettings('premium_charge');

                    if (!$user->premium_expiry_date) {
                        $user->premium_expiry_date = Carbon::now()->addMonths(Helper::getSettings('premium_validity'));
                    } else {
                        $currentDateTime = Carbon::now();
                        $premium_expiry_date = Carbon::parse($user->premium_expiry_date);
                        if ($premium_expiry_date->lt($currentDateTime)) {
                            $premium_expiry_date = $currentDateTime->copy()->addMonths(Helper::getSettings('premium_validity'));
                        } else {
                            $premium_expiry_date->addMonths(Helper::getSettings('premium_validity'));
                        }
                        $user->premium_expiry_date = $premium_expiry_date;
                    }
                }
            }
            $user->wallet = $wallet;
            $user->save();

            $transaction_history = new TransactionHistory();

            $transaction_history->user_id = $request->user_id;
            $transaction_history->transaction_id = $request->transaction_id;
            $transaction_history->phone = $request->phone;
            $transaction_history->amount = $request->amount;
            $transaction_history->cause = $request->for;

            $transaction_history->save();
            DB::commit();
            $response = [
                'status' => 1,
                'data' => $user
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'status' => 0,
                'data' => $e->getMessage()
            ];
            return response()->json($response, 200);
        }
    }
    public function getSettingList()
    {
        $keys = [
            "bkash_number",
            "nagad_number",
            "message_charge",
            "message_validity",
            "premium_validity",
            "premium_charge"
        ];
        $data = [];
        foreach ($keys as $key) {
            $data[$key] = Setting::where('key', $key)->value('value');
        }

        $response = [
            'status' => 1,
            'data' => $data
        ];
        return response()->json($response, 200);
    }
    public function bkash(Request $request)
    {
        // Merchant Info
        $msisdn = "01811181526"; // bKash Merchant Number.
        $user = "01811181526"; // bKash Merchant Username.
        $pass = "W6QpzDen94#EJNP"; // bKash Merchant Password.
        $url = "https://www.bkashcluster.com:9081"; // bKash API URL with Port Number.
        $trxid = $request->transaction_id; // bKash Transaction ID : TrxID.
        // Final URL for getting response from bKash.
        $bkash_url = $url . '/dreamwave/merchant/trxcheck/sendmsg?user=' . $user . '&pass=' . $pass . '&msisdn=' . $msisdn . '&trxid=' . $trxid;

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_PORT => 9081,
                CURLOPT_URL => $bkash_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/json"
                ),

            )
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        //print_r($response); // For Getting all Response Data.
        $api_response = json_decode($response, true); // Getting Response from bKash API.
        $transaction_status = $api_response['transaction']['trxStatus']; // Transaction Status Codes
        if ($err || $transaction_status == "4001") {
            echo 'Problem for Sending Response to bKash API ! Try Again after fews minutes.';
        } else {
            // Assign Transaction Information
            $transaction_amount = $api_response['transaction']['amount']; // bKash Payment Amount.
            $transaction_reference = $api_response['transaction']['reference']; // bKash Reference for Invoice ID.
            $transaction_time = $api_response['transaction']['trxTimestamp']; // bKash Transaction Time & Date.
            // Return Transaction Information into Your Blade Template.
            return view('backend.pages.bkash.bkash', compact('transaction_status', 'transaction_amount', 'transaction_reference', 'transaction_time'));
        }
    }
    public function sendMessage(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = User::find($request->user_id);

            $channel = Channel::whereHas('subscribers', function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            })->first();

            if (!$channel) {
                $channel = new Channel();
                $channel->name = $user->name;
                $channel->is_approved = 0;
                $channel->created_by = $user->id;
                $channel->save();

                $subscriber = new ChannelSubscriber();
                $subscriber->user_id = $user->id;
                $subscriber->channel_id = $channel->id;
                $subscriber->save();
            } elseif(!$user->chat) {
                $channel->is_approved = 0;
                $channel->save();
            }

            $message = new Message();
            $message->channel_id = $channel->id;
            $message->user_id = $request->user_id;
            $message->message = $request->message;

            if ($request->hasFile('files')) {
                $files = [];
                $images = $request->file('files');
                foreach ($images as $image) {
                    $filename = time() . uniqid() . $image->getClientOriginalName();
                    $image->move(public_path('uploads/message-files/'), $filename);
    
                    $extension = strtolower($image->getClientOriginalExtension());
    
                    if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
                        $type = 'image';
                    } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'mkv', 'wmv'])) {
                        $type = 'video';
                    } else {
                        $type = 'document';
                    }
    
                    $files[] = [
                        "type" => $type,
                        "path" => 'uploads/message-files/' . $filename
                    ];
                }
                $message->files = json_encode($files);
            }
            $message->save();
            if ($message->files) {
                $newFiles = [];
                foreach (json_decode($message->files) as $file) {
                    $newFiles[] = [
                        'type' => $file->type,
                        'path' => env('APP_URL') . '/' . $file->path
                    ];
                }
                $message->files = $newFiles;
            }
            $message->user;
            Http::post(env('NODE_URL') . '/send-message-to-user', $message->toArray());
            DB::commit();
            $response = [
                'status' => 0,
                'data' => $message
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                'status' => 0,
                'data' => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    }
    public function getMessage(Request $request)
    {
        try {
            $messages = Message::whereHas('channel.subscribers', function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            })->get();

            $response = [
                'status' => 1,
                'data' => $messages
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = [
                'status' => 0,
                'data' => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    }

    public function sendPushNotification(Request $request) {
        try {
            $title = $request->title ?? 'Title';
            $body = $request->body ?? 'Body';
            $users = DeviceToken::all();
            foreach ($users as $user) {
                SendNotificationJob::dispatch($user->device_token, $title, $body, 'Image');
            }
            $response = [
                'status' => 1,
                'data' => 'Please wait.'
            ];
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = [
                'status' => 0,
                'data' => $e->getMessage()
            ];
            return response()->json($response, 500);
        }
    }
}
