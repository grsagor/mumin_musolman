<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\DriverHistory;
use App\Models\Order;
use App\Models\TruckType;
use App\Models\User;
use Helper;
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
            'email' => 'required|email|unique:user',
            'phone' => 'required|unique:user',
            'gender' => 'required',
            'address' => 'required',
            'role' => 'required',
            'profile_image' => 'required|image|mimes:jpg,png|max:20480'
        ];
        if ($request->role == 3) {
            $rule['driving_experience'] = 'required';
            $rule['driver_truck_type'] = 'required';
            $rule['driving_license_front'] = 'required|image|mimes:jpg,png|max:20480';
            $rule['driving_license_back'] = 'required|image|mimes:jpg,png|max:20480';
        }
        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            $data['status'] = 0;
            $data['data'] = $validator->errors();
            return response()->json($data, 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->address = $request->address;
        $user->role = $request->role;
        $user->driving_experience = $request->driving_experience;
        $user->driver_truck_type = $request->driver_truck_type;
        $user->status = 1;

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $filename = time() . uniqid() . $image->getClientOriginalName();
            $image->move(public_path('uploads/user-images'), $filename);
            $user->profile_image = 'uploads/user-images/' . $filename;
        }
        if ($request->hasFile('driving_license_front')) {
            $image = $request->file('driving_license_front');
            $filename = time() . uniqid() . $image->getClientOriginalName();
            $image->move(public_path('uploads/user-images'), $filename);
            $user->driving_license_front = 'uploads/user-images/' . $filename;
        }
        if ($request->hasFile('driving_license_back')) {
            $image = $request->file('driving_license_back');
            $filename = time() . uniqid() . $image->getClientOriginalName();
            $image->move(public_path('uploads/user-images'), $filename);
            $user->driving_license_back = 'uploads/user-images/' . $filename;
        }

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
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            $data['status'] = 0;
            $data['data'] = $validator->errors();
            return response()->json($data, 200);
        }

        $user = User::where('phone', $request->phone)->first();

        if ($user) {
            $data['token'] = $this->generateToken($user);
            $data['status'] = 1;
            $data['data'] = $user;
            return response()->json($data, 200);
        } else {
            $data['status'] = 0;
            $data['data'] = 'No user registered with this phone number.';
            return response()->json($data, 200);
        }
    }
    private function generateToken($user)
    {
        $token = Str::random(60);
        $user->token = $token;
        $user->save();
        return $token;
    }
    public function updateUser(Request $request) {
        $user = User::find($request->id);
        if ($user) {
            $fillableFields = ['name', 'email', 'phone', 'gender', 'address', 'driving_experience', 'driver_truck_type'];
            foreach ($fillableFields as $field) {
                if ($request->filled($field)) {
                    $user->$field = $request->$field;
                }
            }

            Helper::updateFileField($request, $user, 'profile_image', 'uploads/user-images/');
            Helper::updateFileField($request, $user, 'driving_license_front', 'uploads/user-images/');
            Helper::updateFileField($request, $user, 'driving_license_back', 'uploads/user-images/');

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
    public function storeDeviceToken(Request $request) {
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

    /* Truck Type Started */
    public function getTruckTypeList()
    {
        $truck_types = TruckType::with('truck_type_details')->get();

        $data['status'] = 1;
        $data['data'] = $truck_types;
        return response()->json($data, 200);
    }
    /* Truck Type Ended */

    /* Order Management Start */
    public function storeOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'drop_lat' => 'required',
            'drop_lng' => 'required',
        ]);

        if ($validator->fails()) {
            $data['status'] = 0;
            $data['data'] = $validator->errors();
            return response()->json($data, 200);
        }

        $order = new Order();

        $order->user_id = $request->user_id;
        $order->truck_type_details_id = $request->truck_type_details_id;
        $order->pick_lat = $request->pick_lat;
        $order->pick_lng = $request->pick_lng;
        $order->drop_lat = $request->drop_lat;
        $order->drop_lng = $request->drop_lng;
        $order->pick_date = $request->pick_date;
        $order->pick_time = $request->pick_time;
        $order->pickup_location = $request->pickup_location;
        $order->drop_location = $request->drop_location;
        $order->no_of_truck = $request->no_of_truck;
        $order->shipment_item = $request->shipment_item;
        $order->note = $request->note;
        $order->status = '1';
        $order->distance = $request->distance;
        $order->fare = $request->fare;

        if ($order->save()) {
            $data['status'] = 1;
            $data['data'] = $order;
            return response()->json($data, 200);
        } else {
            $data['status'] = 0;
            $data['data'] = 'Something went wrong during saving order.';
            return response()->json($data, 200);
        }
    }

    public function getOrderList(Request $request) {
        $orders = Order::query()->with('drivers');
        if ($request->has('status')) {
            $orders->where('status', $request->status);
        }
        if ($request->has('user_id')) {
            $orders->where('user_id', $request->user_id);
        }
        $orders = $orders->get();

        if ($orders) {
            $data['status'] = 1;
            $data['data'] = $orders;
            return response()->json($data, 200);
        } else {
            $data['status'] = 0;
            $data['data'] = 'Something went wrong.';
            return response()->json($data, 200);
        }
    }

    public function userDeclineOrder(Request $request) {
        $user_id = $request->user_id;
        $order_id = $request->order_id;

        $order = Order::where([['id', $order_id], ['user_id', $user_id]])->first();
        $order->status = 3;
        if ($order->save()) {
            $response = [
                "status" => 1,
                "data" => $order
            ];
        } else {
            $response = [
                "status" => 0,
                "data" => "Can't cancel"
            ];
        }
        return response()->json($response);
    }
    public function driverAcceptOrder(Request $request) {
        $driver_id = $request->driver_id;
        $order_id = $request->order_id;
        try {
            DB::beginTransaction();
            $order = Order::find($order_id);
            $order->status = 6;
            $order->save();

            $history = DriverHistory::where([['order_id', $order_id], ['driver_id', $driver_id]])->first();
            $history->status = 3;
            $history->save();
            DB::commit();

            $response = [
                "status" => 1,
                "data" => $order
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                "status" => 0,
                "data" => "Can't cancel"
            ];
        }

        return response()->json($response);
    }
    public function driverDeclineOrder(Request $request) {
        $driver_id = $request->driver_id;
        $order_id = $request->order_id;
        try {
            DB::beginTransaction();
            $order = Order::find($order_id);
            $order->status = 5;
            $order->save();

            $history = DriverHistory::where([['order_id', $order_id], ['driver_id', $driver_id]])->first();
            $history->status = 2;
            $history->save();
            DB::commit();

            $response = [
                "status" => 1,
                "data" => $order
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = [
                "status" => 0,
                "data" => "Can't cancel"
            ];
        }

        return response()->json($response);
    }
    /* Order Management End */

    /* Get Nearest Distance */
    public function getNearestDistance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'drop_lat' => 'required',
            'drop_lng' => 'required',
        ]);

        if ($validator->fails()) {
            $data['status'] = 0;
            $data['data'] = $validator->errors();
            return response()->json($data, 200);
        }
        $distance = Helper::distance($request->pick_lat, $request->pick_lng, $request->drop_lat, $request->drop_lng);
        if ($distance) {
            $data['status'] = 1;
            $data['data'] = $distance;
            return response()->json($data, 200);
        } else {
            $data['status'] = 0;
            $data['data'] = 'Something went wrong.';
            return response()->json($data, 200);
        }
    }
    /* Get Nearest Distance End */

    /* Deposit Management Start */
    public function storeDeposit(Request $request) {
        $deposit = new Deposit();

        $deposit->driver_id = $request->driver_id;
        $deposit->ac_holder = $request->ac_holder;
        $deposit->ac_no = $request->ac_no;
        $deposit->transaction_id = $request->transaction_id;
        $deposit->amount = $request->amount;
        $deposit->status = 1;

        if ($request->hasFile('document')) {
            $image = $request->file('document');
            $filename = time() . uniqid() . $image->getClientOriginalName();
            $image->move(public_path('uploads/deposit-images'), $filename);
            $deposit->document = 'uploads/deposit-images/' . $filename;
        }

        if ($deposit->save()) {
            $data['status'] = 1;
            $data['data'] = $deposit;
            return response()->json($data, 200);
        } else {
            $data['status'] = 0;
            $data['data'] = 'Something went wrong.';
            return response()->json($data, 200);
        }
    }
    /* Deposit Management End */
}
