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
        Route::post('login', 'login');
        Route::post('store-device-token', 'storeDeviceToken');
        Route::post('update-user', 'updateUser');
        Route::get('get-truck-type-list', 'getTruckTypeList');

        /* Order mangement start */
        Route::post('order', 'storeOrder');
        Route::get('get-order-list', 'getOrderList');
        Route::post('user-decline-order', 'userDeclineOrder');
        Route::post('driver-decline-order', 'driverDeclineOrder');
        Route::post('driver-accept-order', 'driverAcceptOrder');
        /* Order mangement end */

        /* Get distance */
        Route::post('get-nearest-distance', 'getNearestDistance');

        /* Deposit Management Start */
        Route::post('store-deposit', 'storeDeposit');
        /* Deposit Management End */


        Route::get('get-regular-free-video-list', 'getRegularFreeVideoList');
        Route::get('get-amol-video-list', 'getAmolVideoList');
        Route::get('get-premium-amol-video-list', 'getPremiumAmolVideoList');
        Route::get('get-premium-video-list', 'getPremiumVideoList');
        Route::get('get-live-channel-list', 'getLiveChannelList');
        Route::get('get-tafsir-list', 'getTafsirList');
    });
});
