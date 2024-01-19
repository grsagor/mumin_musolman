<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:user',
            'phone' => 'required|unique:user',
            'gender' => 'required',
            'address' => 'required',
            'profile_image' => 'required|image|mimes:jpg,png|max:20480'
        ]);

        if ($validator->fails()) {
            $data['status'] = 0;
            $data['data'] = $validator->errors();
            return response()->json($data, 200);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
        $user->address = $request->address;
        $user->status = 1;

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $filename = time() . uniqid() . $image->getClientOriginalName();
            $image->move(public_path('uploads/user-images'), $filename);
            $user->profile_image = 'uploads/user-images/' . $filename;
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

    public function any() {
        $data['status'] = 1;
        $data['data'] = "Getssssssss";
        return response()->json($data, 200);
    }

    private function generateToken($user)
    {
        $token = Str::random(60);
        $user->token = $token;
        $user->save();
        return $token;
    }
}
