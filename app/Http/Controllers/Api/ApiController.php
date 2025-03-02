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
            'profile_image' => 'required|image|mimes:jpg,png|max:20480'
        ];

        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $data['status'] = 0;
            $data['data'] = $validator->errors();
            return response()->json($data, 422);
        }

        try {
            DB::beginTransaction();
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
            $user->save();
            DB::commit();

            $data['status'] = 1;
            $data['data'] = $user;
            $data['token'] = $this->generateToken($user);
            return response()->json($data, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $data['status'] = 0;
            $data['data'] = $e->getMessage();
            return response()->json($data, 500);
        }
    }
    public function forgotPassword(Request $request)
    {
        $rule = [
            'email' => 'required|email',
        ];

        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $data['status'] = 0;
            $data['data'] = $validator->errors();
            return response()->json($data, 422);
        }

        try {
            DB::beginTransaction();
            $user = User::where('email', $request->email)->first();

            $otp = rand(1000, 9999);
            $user->otp = $otp;
            $user->otp_expired_at = Carbon::now()->addMinutes(2);

            Helper::updateFileField($request, $user, 'profile_image', 'uploads/user-images/');

            $body = 'Your One time password is ' . $otp . '. Do not share your one time password to anyone.';
            $subject = 'Registration OTP.';

            Mail::to($request->email)->send(new Otp($body, $subject));
            $user->save();
            DB::commit();

            $data['status'] = 1;
            $data['data'] = 'Otp sent';
            return response()->json($data, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $data['status'] = 0;
            $data['data'] = $e->getMessage();
            return response()->json($data, 500);
        }
    }

    public function changePassword(Request $request)
    {
        $rule = [
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ];

        $validator = Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $data['status'] = 0;
            $data['data'] = $validator->errors();
            return response()->json($data, 422);
        }

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
                        $user->password = Hash::make($request->password);
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
            $data['data'] = 'Password changed';
            return response()->json($data, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            $data['status'] = 0;
            $data['data'] = $e->getMessage();
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
            if ($request->device_id) {
                $device_token = DeviceToken::where('device_id', $request->device_id)->first();
                if (!$device_token) {
                    $device_token = new DeviceToken();
                }
            } else {
                $device_token = new DeviceToken();
            }
            $device_token->user_id = $request->id;
            $device_token->device_token = $request->device_token;
            $device_token->device_id = $request->device_id;
            $device_token->expired_at = Carbon::now()->addMonths(2);
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




    public function getCustomAdList()
    {
        $slider = CustomAd::where('ad_no', '!=', 'Banner')->get();
        $popup = CustomAd::where('ad_no', 'Banner')->first();
        $response = [
            "status" => 1,
            "data" => [
                'slider' => $slider,
                'popup' => $popup
            ]
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

                    $users = DeviceToken::where('user_id', $user->id)->get();
                    $title = 'Premium membership';
                    $body = 'You are now a premium member.';
                    foreach ($users as $user) {
                        Helper::sendPushNotification($user->device_token, $title, $body);
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
            } elseif (!$user->chat) {
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
    public function sendPushNotification(Request $request)
    {
        try {
            $title = $request->title ?? 'Title';
            $body = $request->body ?? 'Body';
            $users = DeviceToken::all();
            Helper::sendPushNotification(null, $title, $body);
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

    public function getChannelList()
    {
        try {
            $channels = Channel::where('is_approved', 1)->get();
            foreach ($channels as $channel) {
                $lastMessage = Message::where('channel_id', $channel->id)->orderBy('created_at', 'desc')->first();
                if ($lastMessage) {
                    $channel->last_message = $lastMessage;
                }
            }

            $channels = collect($channels)->sortByDesc(function ($channel) {
                return optional($channel->last_message)->created_at ?? null;
            })->values()->all();

            $response = [
                'status' => 1,
                'data' => $channels
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
    public function getChannelMessageList(Request $request)
    {
        try {
            $messages = Message::with('user')->where('channel_id', $request->channel_id)->get();
            foreach ($messages as $message) {
                $message->files = json_decode($message->files);
            }

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

    public function testPushNotification()
    {
        $serviceAccountPath = storage_path('app/firebase-service-account.json'); // Path to your service         
        if (!file_exists($serviceAccountPath)) {
            throw new \Exception('Service account file not found at ' . $serviceAccountPath);
        }

        $serviceAccount = json_decode(file_get_contents($serviceAccountPath), true);

        if (!$serviceAccount) {
            throw new \Exception('Invalid service account JSON file.');
        }

        // Required variables from the service account
        $clientEmail = $serviceAccount['client_email'];
        $privateKey = $serviceAccount['private_key'];
        $tokenUri = 'https://oauth2.googleapis.com/token';

        // Create a JWT header
        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT',
        ];

        // Create a JWT payload
        $now = time();
        $payload = [
            'iss' => $clientEmail, // Issuer (the client email from service account)
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging', // Required scope
            'aud' => $tokenUri, // Audience
            'iat' => $now, // Issued at
            'exp' => $now + 3600, // Expiry (1 hour)
        ];

        // Encode the header and payload to Base64
        $base64Header = rtrim(strtr(base64_encode(json_encode($header)), '+/', '-_'), '=');
        $base64Payload = rtrim(strtr(base64_encode(json_encode($payload)), '+/', '-_'), '=');

        // Create the signature
        $dataToSign = $base64Header . '.' . $base64Payload;
        $signature = '';
        openssl_sign($dataToSign, $signature, $privateKey, 'SHA256');
        $base64Signature = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

        // Create the JWT
        $jwt = $base64Header . '.' . $base64Payload . '.' . $base64Signature;

        // Exchange the JWT for an access token
        $response = self::makeHttpRequest($tokenUri, [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        if (!isset($response['access_token'])) {
            throw new \Exception('Failed to generate access token: ' . json_encode($response));
        }

        $accessToken = $response['access_token'];

        $fcmAuthKey = env('FCM_AUTH_KEY');

        $data = [
            "message" => [
                "token" => "emGEBPPbTMyZa8YRezkVjx:APA91bG7-ZPQ_YDs2xaBlEJ9BGjPTfVJqLDimyrjiQQyR2YXTJJkrdSCyn-NU58c0Y08xDCtew6PIPEThTPpW3b5dmVmiBeL5CjC5GnC0lRNCYbym33IBEo",
                "notification" => [
                    "body" => "This is an FCM notification message!",
                    "title" => "FCM Message"
                ]
            ]
        ];
        $data = [
            'message' => [
                'topic' => 'global',
                'notification' => [
                    'title' => 'Breaking News',
                    'body' => 'New news story available.',
                ],
                'data' => [
                    'story_id' => 'story_12345',
                ],
            ],
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/v1/projects/mumin-mosolman/messages:send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $accessToken",
                "Content-Type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return response()->json([
            'success' => true,
            'data' => $response
        ]);
    }

    private static function makeHttpRequest($url, $postData)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new \Exception('HTTP Error: ' . $httpCode . ', Response: ' . $response);
        }

        return json_decode($response, true);
    }
}
