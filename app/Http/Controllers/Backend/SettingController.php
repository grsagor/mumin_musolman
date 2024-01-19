<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;
use Helper;
use Hash;
use Image;
use App\Models\User;
use App\Models\Company;
use App\Models\Setting;
use Session;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            if (!$this->user || $this->user->role == 2 || Helper::hasRight('user.view') == false) {
                session()->flash('error', 'You can not access! Login first.');
                return redirect()->route('admin');
            }
            return $next($request);
        });
    }

    public function general(){
        return view('backend.pages.setting.general');
    }

    public function staticContent(){
        return view('backend.pages.setting.static-content');
    }

    public function legalContent (){
        return view('backend.pages.setting.legal-content');
    }

    public function update(Request $request){
        $data = [];

        foreach($request->file() as $key => $val){
            if ($request->hasFile($key)) {
                // if (file_exists(public_path('uploads/settings/'.Helper::getSettings($key)))) {
                //     unlink(public_path('uploads/settings/'.Helper::getSettings($key)));
                // }
                $image = $request->file($key);
                $filename = time().uniqid().$image->getClientOriginalName();
                $image->move(public_path('uploads/settings'), $filename);
                $data[$key] = $filename;
            }
        }

        foreach ($request->input() as $key => $val) {
            if (!is_array($val)) {
                $request->validate([
                    $val => 'nullable | string'
                ]);
                $data[$key] = $val;
            } else {
                $data[$key] = implode(',', $val);
            }
        }
        unset($data['_token']);

        foreach ($data as $key => $val) {
            $settings = Setting::updateOrCreate(
                ['key' =>  $key],
                ['value' => $val]
            );
        }
        session()->flash('success', 'Settings Successfully Updated!');
        return back();
    }

    public function changeLanguage(Request $request){
        $language = $request->input('language');
        Session::put('admin_language', $language);
        return true;
    }
}
