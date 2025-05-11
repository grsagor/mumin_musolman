<?php

namespace App\Http\Controllers\BKash;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BkashController extends Controller
{
    private $base_url;
    private $app_key;
    private $app_secret;
    private $username;
    private $password;

    public function __construct()
    {
        // bKash Merchant API Information

        // You can import it from your Database
        $bkash_app_key = '5tunt4masn6pv2hnvte1sb5n3j'; // bKash Merchant API APP KEY
        $bkash_app_secret = '1vggbqd4hqk9g96o9rrrp2jftvek578v7d2bnerim12a87dbrrka'; // bKash Merchant API APP SECRET
        $bkash_username = 'sandboxTestUser'; // bKash Merchant API USERNAME
        $bkash_password = 'hWD@8vtzw0'; // bKash Merchant API PASSWORD
        $bkash_base_url = 'https://checkout.sandbox.bka.sh/v1.2.0-beta'; // For Live Production URL: https://checkout.pay.bka.sh/v1.2.0-beta

        $this->app_key = $bkash_app_key;
        $this->app_secret = $bkash_app_secret;
        $this->username = $bkash_username;
        $this->password = $bkash_password;
        $this->base_url = $bkash_base_url;
    }

    public function index(Request $request)
    {
        $for = $request->for;
        $payment_session = Session::get('payment_session');
        $payment_session['for'] = $for;
        Session::put('payment_session', $payment_session);
        if (!in_array($for, ['chat', 'premium'])) {
            Session::put('payment_session', []);
            return 'Please select a valid option';
        }
        return view('bkash.bkash-payment');
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

        return response()->json(['success', true]);
    }

    public function createPayment(Request $request)
    {
        $requestData['amount'] = 10;

        $token = session()->get('bkash_token');

        $requestData['intent'] = 'sale';
        $requestData['currency'] = 'BDT';
        $requestData['merchantInvoiceNumber'] = 'INV' . time();
        $requestData['merchantCallbackURL'] = url('/bkash');

        $url = curl_init("$this->base_url/checkout/payment/create");
        $request_data_json = json_encode($requestData);
        $header = array(
            'Content-Type:application/json',
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
        \Log::info('calling');
        try {
            $user = Auth::user();
            if($request->payment_info['transactionStatus'] == 'Completed') {
                \Log::info('calling completed');
                $payment_session = Session::get('payment_session');
                $requestBody = [
                    'user_id' => $user->id,
                    'amount' => $request->payment_info['amount'],
                    'transaction_id' => $request->payment_info['trxID'],
                    'for' => $payment_session['for'],
                    'phone' => $request->payment_info['customerMsisdn'] ?? null // Add phone number
                ];
                
                $response = Http::post(url('/api/v1/payment'), $requestBody);
                \Log::info('calling response get');
                $responseData = $response->json(); // Decode JSON response
                
                if ($responseData['status'] == 1) { // Check status from response data
                    \Log::info('calling response status 1');
                    Session::put('payment_session', []);
                    return response()->json([
                        'success' => true,
                        'redirect_url' => route('payment.success.page'),
                    ]);
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

    public function successPage() {
        return view('bkash.bkash-payment-success');
    }
}
