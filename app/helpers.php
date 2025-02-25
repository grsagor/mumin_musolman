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
        if ($role_id != null) {
            $role = $role_id;
        } else {
            $role = \Auth::user()->role;
        }
        $right = Right::where('name', $right)->first();
        if ($right) {
            if (RoleRight::where('role_id', $role)->where('right_id', $right->id)->where('permission', 1)->exists()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
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

    public static function distance($pickupLat = null, $pickupLng = null, $destinationLat = null, $destinationLng = null)
    {
        $apiKey = config('services.google_maps.api_key');
        $client = new Client();

        $result = [];

        if ($pickupLat && $pickupLng) {
            $pickupResponse = $client->get("https://maps.googleapis.com/maps/api/geocode/json", [
                'query' => [
                    'latlng' => "$pickupLat,$pickupLng",
                    'key' => $apiKey,
                ],
            ]);
            $pickupData = json_decode($pickupResponse->getBody(), true);
            $result["pickup_location"] = $pickupData['results'][0]['formatted_address'];
        } else {
            $result["pickup_location"] = null;
        }

        if ($destinationLat && $destinationLng) {
            $dropResponse = $client->get("https://maps.googleapis.com/maps/api/geocode/json", [
                'query' => [
                    'latlng' => "$destinationLat,$destinationLng",
                    'key' => $apiKey,
                ],
            ]);
            $dropData = json_decode($dropResponse->getBody(), true);
            $result["drop_location"] = $dropData['results'][0]['formatted_address'];
        } else {
            $result["drop_location"] = null;
        }

        if ($pickupLat && $pickupLng && $destinationLat && $destinationLng) {
            $response = $client->get("https://maps.googleapis.com/maps/api/directions/json", [
                'query' => [
                    'origin' => "$pickupLat,$pickupLng",
                    'destination' => "$destinationLat,$destinationLng",
                    'key' => $apiKey,
                    'mode' => 'driving',
                    'avoid' => 'ferries',
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            $distance_meter = $data['routes'][0]['legs'][0]['distance']['value'];
            $distance_km = $distance_meter / 1000;
            $result["distance"] = ceil($distance_km);
        } else {
            $result["distance"] = null;
        }

        return $result;
    }

    public static function updateFileField(Request $request, $table, $fieldName, $path)
    {
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

    // public static function sendPushNotification($device_token, $title, $body, $image)
    // {
    //     $fcmAuthKey = env('FCM_AUTH_KEY');

    //     $data = [
    //         'to' => $device_token,
    //         'content_available' => true,
    //         "sticky" => true,
    //         'notification' => [
    //             'title' => $title,
    //             'body' => $body,
    //         ],
    //         'data' => [
    //             'title' => $title,
    //             'body' => json_encode($body),
    //         ],
    //     ];
    //     $curl = curl_init();
    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => "",
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => "POST",
    //         CURLOPT_POSTFIELDS => json_encode($data),
    //         CURLOPT_HTTPHEADER => array(
    //             "Authorization: key=$fcmAuthKey",
    //             "Content-Type: application/json"
    //         ),
    //     ));
    //     $response = curl_exec($curl);
    //     curl_close($curl);
    //     return json_decode($response);
    // }

    public static function sendPushNotification($device_token, $title, $body)
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
                    "title" => $title,
                    "body" => $body
                ]
            ]
        ];
        $data = [
            'message' => [
                'topic' => 'global',
                'notification' => [
                    'title' => $title,
                    'body' => $body
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
