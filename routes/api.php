<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TruckApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function () {
    Route::controller(ApiController::class)->group(function() {
        Route::post('register', 'register');
        Route::post('verify-otp', 'verifyOtp');
        Route::post('login', 'login');
        Route::post('store-device-token', 'storeDeviceToken');
        Route::post('update-user', 'updateUser');
        Route::get('get-user-details', 'getUserDetails');

        Route::post('forgot-password', 'forgotPassword');
        Route::post('change-password', 'changePassword');

        Route::get('get-regular-free-video-list', 'getRegularFreeVideoList');
        Route::get('get-regular-free-video-details', 'getRegularFreeVideoDetails');

        Route::get('get-amol-video-list', 'getAmolVideoList');
        Route::get('get-amol-video-details', 'getAmolVideoDetails');

        Route::get('get-premium-amol-video-list', 'getPremiumAmolVideoList');
        Route::get('get-premium-amol-video-details', 'getPremiumAmolVideoDetails');

        Route::get('get-premium-video-list', 'getPremiumVideoList');
        Route::get('get-premium-video-details', 'getPremiumVideoDetails');

        Route::get('get-live-channel-list', 'getLiveChannelList');
        Route::get('get-live-channel-details', 'getLiveChannelDetails');

        Route::get('get-tafsir-list', 'getTafsirList');
        Route::get('get-tafsir-details', 'getTafsirDetails');

        Route::get('get-custom-ad-list', 'getCustomAdList');
        Route::get('get-custom-ad-details', 'getCustomAdDetails');

        Route::post('payment', 'storePayment');
        Route::get('get-setting-list', 'getSettingList');

        Route::post('bkash-transaction-status', 'bkash');

        Route::post('send-message', 'sendMessage');
        Route::get('get-message', 'getMessage');

        Route::post('send-push-notification', 'sendPushNotification');

        Route::get('get-channel-list', 'getChannelList');
        Route::get('get-channel-message-list', 'getChannelMessageList');
    });
});
