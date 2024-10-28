<?php

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\Right;
use App\Models\RoleRight;
use App\Models\Setting;
use App\Models\Otp;
use App\Models\Translation;
use App\Models\User;
use GuzzleHttp\Client;

class Helper
{

    public static function hasRight($right, $role_id = null)
    {
        return true;
    }

    public static function getSettings($key)
    {
        $settings = Setting::where('key', $key)->first();
        if (!is_null($settings)) {
            return $settings->value;
        } else {
            return false;
        }
    }

    public static function generateUsername($string)
    {
        $user_name = str_replace(' ', '', $string);
        if (!User::where('user_name', $user_name)->exists()) {
            return strtolower($user_name);
        }
        $number = 1;
        do {
            $number++;
            $user_name = $string . $number;
        } while (User::where('user_name', $user_name)->exists());

        return strtolower($user_name);
    }


    public static function sendEmail($email, $subject, $data, $template = 'default')
    {
        Mail::send('mails.' . $template, ['data' => $data], function ($message) use ($email, $subject) {
            $message->from(env('MAIL_FROM_ADDRESS'), $subject);
            $message->to($email)->subject($subject);
        });
    }

    public static function checkotp($email, $otp)
    {
        $otp = Otp::where('email', $email)->where('otp', $otp)->where('status', 0)->first();
        if ($otp) {
            return true;
        }
    }

    public static function updateFileField(Request $request, $table, $fieldName, $path) {
        if ($request->hasFile($fieldName)) {
            if ($table->$fieldName != null && file_exists(public_path($table->$fieldName))) {
                unlink(public_path($table->$fieldName));
            }
            $image = $request->file($fieldName);
            $filename = time() . uniqid() . $image->getClientOriginalName();
            $image->move(public_path($path), $filename);
            $table->$fieldName = $path . $filename;
        }
    }
}
