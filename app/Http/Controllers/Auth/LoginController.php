<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;
use Hash;
use Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function signup(Request $request){
        $validator = Validator::make($request->all(), [
			'name' => 'required',
			'email' => 'required|unique:user',
			'password' => 'required|min:8|confirmed',
			'password_confirmation' => 'required',
		]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->user_name = Helper::generateUsername($request->name);
        $user->email = $request->email;
        $user->role  = 2;
        $user->password  = Hash::make($request->password);
        $user->status  = 0;
        if($user->save()){
            $subject = 'Register confirmation';
            $data['user'] = $user;
            $data['message'] = 'Thank you for registering on Mumin Musolman! We\'re excited to have you as part of our community.';
            if(filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                Helper::sendEmail($user->email, $subject, $data, 'registration-confirmation');
            }
            return redirect()->back()->with('message', 'Your registration successfully complete!');
        }else{
            return redirect()->back()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
			'email' => 'required',
			'password' => 'required',
		]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->email)->first();

        if ($user && $user->status == 1) {
            if (Auth::attempt($credentials)) {
                $authUser = Auth()->user()->role;
                if ($authUser == 3 || $authUser == 4) {
                    return redirect()->route('frontend.home');
                }else{
                    return redirect()->route('admin.index');
                }
            }else{
                return redirect()->back()->withErrors(['error' => 'Invalid credentials.']);
            }
        }else{
            return redirect()->back()->withErrors(['error' => 'Your account is not active yet!.']);
        }

    }

    public function logout(Request $request)
	{
        if (Session::get('session_id') != null || Session::forget('user_id') != null) {
            $carts = Helper::getCart();
            if($carts){
                Cart::where(function($query) {
                    $query->where('session_id', Session::get('session_id'))
                    ->orwhere('user_id', Session::get('user_id'));
                })->delete();

                Session::forget('user_id');
                Session::forget('session_id');
            }
        }

		Auth::logout();
		$request->session()->invalidate();
		return redirect()->route('login');
	}

    public function adminProfile(){
        $user = Auth::user();
        return view('backend.auth.profile', compact('user'));
    }

    public function adminProfileUpdate(Request $request){
        $validator = Validator::make($request->all(), [
			'profile_image' => 'nullable|image:png,jpg,jpeg,gif,webp,',
		]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->phone = $request->phone;
        if($request->hasFile('profile_image')){
            if (file_exists(public_path($user->profile_image))) {
                unlink(public_path($user->profile_image));
            }
            $image = $request->file('profile_image');
            $filename = time().uniqid().$image->getClientOriginalName();
            $image->move(public_path('uploads/user-images'), $filename);
            $user->profile_image = 'uploads/user-images/'.$filename;
        }
        if($user->save()){
            return redirect()->back()->with('success', 'Your profile has been updated.');
        }else{
            return redirect()->back()->withErrors(['error' => 'Something went wrong.']);
        }
    }

    public function adminProfileSetting(){
        $user = Auth::user();
        return view('backend.auth.setting', compact('user'));
    }

    public function adminChangePassword(Request $request){
        $validator = Validator::make($request->all(), [
			'current_password' => 'required',
			'password' => 'required|min:8|confirmed',
			'password_confirmation' => 'required',
		]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find(Auth::user()->id);
        if (Hash::check($request->current_password, $user->password)) {
            $user->password = Hash::make($request->password);
            if ($user->save()) {
                return redirect()->back()->with('success', 'Password has been changed.');
            }else{
                return redirect()->back()->withErrors(['error' => 'Something went wrong.']);
            }
        }else{
            return redirect()->back()->withErrors(['error' => 'Current password not match.']);
        }
    }
}
