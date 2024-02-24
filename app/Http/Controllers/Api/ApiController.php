<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\Otp;
use App\Models\AmolVideo;
use App\Models\LiveChannel;
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
    public function storeDeviceToken(Request $request)
    {
        $user = User::find($request->id);
        $user->device_token = $request->device_token;
        if ($user->save()) {
            $data['status'] = 1;
            $data['data'] = $user;
            return response()->json($data, 200);
        } else {
            $data['status'] = 0;
            $data['data'] = 'No user registered with this phone number.';
            return response()->json($data, 200);
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
    public function getAmolVideoList()
    {
        $data = AmolVideo::orderByDesc('created_at')->get();
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
    public function getPremiumVideoList()
    {
        $data = PremiumVideo::orderByDesc('created_at')->get();
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
    public function getTafsirList()
    {
        $data = Tafsir::orderByDesc('created_at')->get();
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
}
