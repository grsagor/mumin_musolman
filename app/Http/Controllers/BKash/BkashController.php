<?php

namespace App\Http\Controllers\BKash;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Helper;
use Illuminate\Support\Facades\Log;

class BkashController extends Controller
{
    private $base_url;
    private $app_key;
    private $app_secret;
    private $username;
    private $password;
    private $amount;

    public function __construct(Request $request)
    {
        // bKash Merchant API Information

        // You can import it from your Database
        // $bkash_app_key = '4f6o0cjiki2rfm34kfdadl1eqq'; // bKash Merchant API APP KEY
        // $bkash_app_secret = '2is7hdktrekvrbljjh44ll3d9l1dtjo4pasmjvs5vl5qr3fug4b'; // bKash Merchant API APP SECRET
        // $bkash_username = 'sandboxTokenizedUser02'; // bKash Merchant API USERNAME
        // $bkash_password = 'sandboxTokenizedUser02@12345'; // bKash Merchant API PASSWORD
        // $bkash_base_url = 'https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized'; // For Live Production URL: https://checkout.pay.bka.sh/v1.2.0-beta
        $bkash_app_key = 'rGrhiWtYcacOfLAqxLZN5vFZtc'; // bKash Merchant API APP KEY
        $bkash_app_secret = 'jxTnkEdZzx9y5xS88qgjMbb9Urb02fyW5FfK5Jv1CcmXPXJZG3d9'; // bKash Merchant API APP SECRET
        $bkash_username = '01811181526'; // bKash Merchant API USERNAME
        $bkash_password = 'cZpu?#I&Bw7'; // bKash Merchant API PASSWORD
        $bkash_base_url = 'https://tokenized.pay.bka.sh/v1.2.0-beta/tokenized';

        $this->app_key = $bkash_app_key;
        $this->app_secret = $bkash_app_secret;
        $this->username = $bkash_username;
        $this->password = $bkash_password;
        $this->base_url = $bkash_base_url;
        
        if ($request->query('for') === 'premium') {
            $this->amount = Helper::getSettings('premium_charge');
        } else {
            $this->amount = Helper::getSettings('message_charge'); // default or fallback
        }
    }

    public function index(Request $request)
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }
        $for = $request->for;
        $payment_session = Session::get('payment_session');
        $payment_session['for'] = $for;
        Session::put('payment_session', $payment_session);
        if (!in_array($for, ['chat', 'premium'])) {
            Session::put('payment_session', []);
            return 'Please select a valid option';
        }
        return view('bkash.bkash-payment', [
            'amount' => $this->amount
        ]);
    }

    public function getToken()
    {
        session()->forget('bkash_token');

        $post_token = array(
            'app_key' => $this->app_key,
            'app_secret' => $this->app_secret
        );

        $url = curl_init("$this->base_url/checkout/token/grant");
        $post_token = json_encode($post_token);
        $header = array(
            'Content-Type:application/json',
            "password:$this->password",
            "username:$this->username"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $post_token);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdata = curl_exec($url);
        curl_close($url);

        $response = json_decode($resultdata, true);

        if (array_key_exists('msg', $response)) {
            return $response;
        }

        session()->put('bkash_token', $response['id_token']);

        return response()->json(['success' => true, 'token' => $response['id_token']]);
    }

    public function createPayment(Request $request)
    {
        $requestData['amount'] = $this->amount;

        $token = session()->get('bkash_token');

        $requestData['mode'] = '0011';
        $requestData['payerReference'] = '01723888888';
        $requestData['callbackURL'] = route('payment.success.page');
        $requestData['merchantAssociationInfo'] = 'MI05MID54RF09123456One';
        $requestData['intent'] = 'sale';
        $requestData['currency'] = 'BDT';
        $requestData['merchantInvoiceNumber'] = 'INV' . time();

        $url = curl_init("$this->base_url/checkout/create");
        $request_data_json = json_encode($requestData);
        $header = array(
            'Content-Type: application/json',
            'Accept: application/json',
            "authorization: $token",
            "x-app-key: $this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $request_data_json);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);
        curl_close($url);
        session()->put('bkash_amount', $this->amount);
        return json_decode($resultdata, true);
    }

    public function executePayment(Request $request)
    {
        $token = session()->get('bkash_token');

        $paymentID = $request->paymentID;
        $url = curl_init("$this->base_url/checkout/payment/execute/" . $paymentID);
        $header = array(
            'Content-Type:application/json',
            "authorization:$token",
            "x-app-key:$this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdata = curl_exec($url);
        curl_close($url);
        return json_decode($resultdata, true);
    }

    public function queryPayment(Request $request)
    {
        $token = session()->get('bkash_token');
        $paymentID = $request->payment_info['payment_id'];

        $url = curl_init("$this->base_url/checkout/payment/query/" . $paymentID);
        $header = array(
            'Content-Type:application/json',
            "authorization:$token",
            "x-app-key:$this->app_key"
        );

        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        $resultdata = curl_exec($url);
        curl_close($url);
        return json_decode($resultdata, true);
    }

    public function bkashSuccess(Request $request)
    {
        $status = $request->query('status');
        try {
            $user = Auth::user();
            if ($status == 'success') {
                $payment_session = Session::get('payment_session');
                $amount = Session::get('bkash_amount');
                $requestBody = [
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'transaction_id' => 'asdfasdf',
                    'for' => $payment_session['for'],
                    'phone' => null // Add phone number
                ];
                $responseData = [];
                try {
                    $paymentController = new ApiController();
                    $responseData = $paymentController->storePayment(new Request($requestBody))->getData(true);
                } catch (\Throwable $th) {
                    return response()->json([
                        'success' => false,
                        'message' => $th->getMessage()
                    ]);
                }

                if ($responseData['status'] == 1) { // Check status from response data
                    Session::put('payment_session', []);
                    return view('bkash.bkash-payment-success');
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Payment processing failed',
                    'response' => $responseData
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Transaction not completed'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
    
    private function verifyPaymentStatus($paymentID)
    {
        // Get the access token from session
        $token = session()->get('bkash_token');

        // Set the URL for checking the payment status
        $url = curl_init("{$this->base_url}/checkout/payment/status");

        // Set the data to be sent in the POST request
        $requestData = json_encode([
            'paymentID' => $paymentID
        ]);

        // Set the HTTP headers
        $headers = [
            'Content-Type: application/json',
            "Authorization: Bearer $token",
            "x-app-key: {$this->app_key}",
        ];

        // cURL settings
        curl_setopt($url, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $requestData);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);

        // Execute cURL request and get the response
        $resultData = curl_exec($url);
        curl_close($url);

        // Decode the JSON response
        return json_decode($resultData, true);
    }

    public function successPage()
    {
        return view('bkash.bkash-payment-success');
    }
}
