<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use Helper;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registration()
    {
        return view('auth.pages.registration');
    }

    public function login()
    {
        return view('auth.pages.login');
    }

    public function forgotPassword()
    {
        App::setLocale(Session::get('language'));
        return view('auth.pages.forgot-password');
    }

    public function resetOtpSend(Request $request)
    {

        if (User::where('email', $request->email)->exists()) {
            $email = $request->email;
            $otps = random_int(100000, 999999);
            $subject = 'Password Reset';
            $data['user'] = User::where('email', $request->email)->first();
            $data['otp'] = $otps;
            $data['message'] = 'Your confirmation code is below — enter it in your open browser window and we will help you get changed password. Please do not share the code others';
            Helper::sendEmail($email, $subject, $data, 'resetpassword');

            $otp = new Otp();
            $otp->email = $request->email;
            $otp->otp = $otps;
            $otp->save();

            return view('auth.pages.otp', compact('email'));
        } else {
            return redirect()->back()->withErrors(['message' => 'There is no account with this email!']);
        }
    }

    public function otp(Request $request)
    {
        App::setLocale(Session::get('language'));
        if ($request->email && $request->otp) {
            Validator::make($request->all(), [
                'email' => 'required',
                'otp' => 'required',
                'password' => 'required',
                'password_confirmation' => 'required_with:password|same:password|min:6',
            ]);

            if (Helper::checkotp($request->email, $request->otp)) {
                $email = $request->email;
                $user = User::where('email', $request->email)->first();
                $user->password = Hash::make($request->password);
                if ($user->save()) {
                    $otp = Otp::where('email', $request->email)->where('otp', $request->otp)->first();
                    $otp->status = 1;
                    $otp->save();
                    return redirect()->route('admin')->with(['message' => 'Password changed successfully!']);
                } else {
                    return view('auth.pages.otp', compact('email'))->withErrors(['message' => 'OTP invalid or expaired!']);
                }
            } else {
                $email = $request->email;
                return view('auth.pages.otp', compact('email'))->withErrors(['message' => 'OTP invalid or expaired!']);
            }
        } else {
            return view('auth.pages.otp');
        }
    }

    public function pages($slug)
    {
        App::setLocale(Session::get('language'));
        $content = '';
        if ($slug == 'terms-and-conditions') {
            $content = Helper::getSettings('terms_and_conditions');
        } else if ($slug == 'privacy-policy') {
            $content = Helper::getSettings('privacy_policy');
        } else if ($slug == 'return-policy') {
            $content = Helper::getSettings('return_policy');
        }
        return view('frontend.pages.page', compact('slug', 'content'));
    }

    public function changeLanguage(Request $request)
    {

        $language = $request->input('language');

        Session::put('language', $language);

        return true;
    }
}
