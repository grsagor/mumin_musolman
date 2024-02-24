<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Backend\AlluserController;
use App\Http\Controllers\Backend\AmolvideoController;
use App\Http\Controllers\Backend\CustomadsController;
use App\Http\Controllers\Backend\LivechannelController;
use App\Http\Controllers\Backend\PaiduserController;
use App\Http\Controllers\Backend\PaymentrequestController;
use App\Http\Controllers\Backend\PremiumamolvideoController;
use App\Http\Controllers\Backend\PremiumvideoController;
use App\Http\Controllers\Backend\RegularvideoController;
use App\Http\Controllers\Backend\TafsirController;
use App\Http\Controllers\Backend\TotalmessageController;
use App\Http\Controllers\Backend\TransactionHistoryController;
use App\Http\Controllers\SslCommerzPaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\BookingController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\TruckTypeController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::controller(AuthController::class)->group(function() {
    Route::get('/', 'login');
    Route::get('login', 'login')->name('login');
    Route::get('register', 'registration')->name('register');
    Route::get('reset-password', 'forgotPassword');
    Route::any('reset-otp-send', 'resetOtpSend');
    Route::any('change-password', 'otp');
});

// Auth route
Route::post('login-post', [LoginController::class, 'authenticate'])->name('login.post');
Route::post('signup', [LoginController::class, 'signup'])->name('registration.post');

// admin route start
Route::get('/admin', function () {
    if (Auth::user()) {
        return redirect()->route('admin.index');
    }else{
        return view('auth.pages.login');
    }
})->name('admin');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('profile', [LoginController::class, 'adminProfile'])->name('admin.profile');
    Route::post('profile/update', [LoginController::class, 'adminProfileUpdate'])->name('admin.profile.update');
    Route::get('profile/setting', [LoginController::class, 'adminProfileSetting'])->name('admin.profile.setting');
    Route::post('profile/change/password', [LoginController::class, 'adminChangePassword'])->name('admin.change.password');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.index');

    Route::group(['prefix' => '/user'], function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.user');
        Route::get('/get/list', [UserController::class, 'getList']);
        Route::post('/store', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::any('/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('admin.user.delete');
        Route::post('/change', [UserController::class, 'changePassword'])->name('admin.user.changepassword');

        Route::get('/{id}', [UserController::class, 'userDetails'])->name('admin.user.details');
    });

    Route::group(['prefix' => '/role'], function () {
        Route::get('/generate/right/{mdule_name}', [RoleController::class, 'generate'])->name('admin.role.right.generate');

        Route::get('/', [RoleController::class, 'index'])->name('admin.role');
        Route::get('/get/role/list', [RoleController::class, 'getRoleList']);
        Route::get('/create', [RoleController::class, 'create'])->name('admin.role.create');
        Route::post('/store', [RoleController::class, 'store'])->name('admin.role.store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('admin.role.edit');
        Route::any('/update/{id}', [RoleController::class, 'update'])->name('admin.role.update');
        Route::get('/delete/{id}', [RoleController::class, 'delete'])->name('admin.role.delete');

        Route::get('/right', [RoleController::class, 'right'])->name('admin.role.right');
        Route::get('/get/right/list', [RoleController::class, 'getRightList']);
        Route::post('/right/store', [RoleController::class, 'rightStore'])->name('admin.role.right.store');
        Route::get('/right/edit/{id}', [RoleController::class, 'editRight'])->name('admin.role.right.edit');
        Route::any('/right/update/{id}', [RoleController::class, 'roleRightUpdate'])->name('admin.role.right.update');
        Route::get('/right/delete/{id}', [RoleController::class, 'rightDelete'])->name('admin.role.right.delete');
    });

    Route::group(['prefix' => '/setting'], function () {
        Route::get('/general', [SettingController::class, 'general'])->name('admin.setting.general');
        Route::get('/static-content', [SettingController::class, 'staticContent'])->name('admin.setting.static.content');
        Route::get('/legal-content', [SettingController::class, 'legalContent'])->name('admin.setting.legal.content');
        Route::post('/update', [SettingController::class, 'update'])->name('admin.setting.update');
        Route::get('/change-language', [SettingController::class, 'changeLanguage'])->name('admin.setting.change.language');
    });

    Route::group(['prefix' => '/truck-type'], function () {
        Route::get('/', [TruckTypeController::class, 'index'])->name('admin.truck.type');
        Route::get('/get/list', [TruckTypeController::class, 'getList']);
        Route::post('/store', [TruckTypeController::class, 'store'])->name('admin.truck.type.store');
        Route::get('/edit', [TruckTypeController::class, 'edit'])->name('admin.truck.type.edit');
        Route::any('/update', [TruckTypeController::class, 'update'])->name('admin.truck.type.update');
        Route::get('/delete', [TruckTypeController::class, 'delete'])->name('admin.truck.type.delete');
        Route::get('rent-amount-html', [TruckTypeController::class, 'rentAmountHtml'])->name('admin.truck.type.rent.amount.html');
        Route::get('rent-amount-increment', [TruckTypeController::class, 'rentAmountIncrement'])->name('admin.truck.type.rent.amount.increment');
        Route::get('distance', [TruckTypeController::class, 'distance']);
    });
    Route::group(['prefix' => '/regular-video-free'], function () {
        Route::get('/', [RegularvideoController::class, 'index'])->name('admin.regular.video.free');
        Route::get('/get/list', [RegularvideoController::class, 'getList'])->name('admin.regular.video.free.get.list');
        Route::post('/store', [RegularvideoController::class, 'store'])->name('admin.regular.video.free.store');
        Route::get('/edit', [RegularvideoController::class, 'edit'])->name('admin.regular.video.free.edit');
        Route::any('/update', [RegularvideoController::class, 'update'])->name('admin.regular.video.free.update');
        Route::get('/delete', [RegularvideoController::class, 'delete'])->name('admin.regular.video.free.delete');
    });
    Route::group(['prefix' => '/amol-video-free'], function () {
        Route::get('/', [AmolvideoController::class, 'index'])->name('admin.amol.video.free');
        Route::get('/get/list', [AmolvideoController::class, 'getList'])->name('admin.amol.video.free.get.list');
        Route::post('/store', [AmolvideoController::class, 'store'])->name('admin.amol.video.free.store');
        Route::get('/edit', [AmolvideoController::class, 'edit'])->name('admin.amol.video.free.edit');
        Route::any('/update', [AmolvideoController::class, 'update'])->name('admin.amol.video.free.update');
        Route::get('/delete', [AmolvideoController::class, 'delete'])->name('admin.amol.video.free.delete');
    });
    Route::group(['prefix' => '/amol-video-premium'], function () {
        Route::get('/', [PremiumamolvideoController::class, 'index'])->name('admin.amol.video.premium');
        Route::get('/get/list', [PremiumamolvideoController::class, 'getList'])->name('admin.amol.video.premium.get.list');
        Route::post('/store', [PremiumamolvideoController::class, 'store'])->name('admin.amol.video.premium.store');
        Route::get('/edit', [PremiumamolvideoController::class, 'edit'])->name('admin.amol.video.premium.edit');
        Route::any('/update', [PremiumamolvideoController::class, 'update'])->name('admin.amol.video.premium.update');
        Route::get('/delete', [PremiumamolvideoController::class, 'delete'])->name('admin.amol.video.premium.delete');
    });
    Route::group(['prefix' => '/video-premium'], function () {
        Route::get('/', [PremiumvideoController::class, 'index'])->name('admin.video.premium');
        Route::get('/get/list', [PremiumvideoController::class, 'getList'])->name('admin.video.premium.get.list');
        Route::post('/store', [PremiumvideoController::class, 'store'])->name('admin.video.premium.store');
        Route::get('/edit', [PremiumvideoController::class, 'edit'])->name('admin.video.premium.edit');
        Route::any('/update', [PremiumvideoController::class, 'update'])->name('admin.video.premium.update');
        Route::get('/delete', [PremiumvideoController::class, 'delete'])->name('admin.video.premium.delete');
    });
    Route::group(['prefix' => '/live-channel'], function () {
        Route::get('/', [LivechannelController::class, 'index'])->name('admin.live.channel');
        Route::get('/get/list', [LivechannelController::class, 'getList'])->name('admin.live.channel.get.list');
        Route::post('/store', [LivechannelController::class, 'store'])->name('admin.live.channel.store');
        Route::get('/edit', [LivechannelController::class, 'edit'])->name('admin.live.channel.edit');
        Route::any('/update', [LivechannelController::class, 'update'])->name('admin.live.channel.update');
        Route::get('/delete', [LivechannelController::class, 'delete'])->name('admin.live.channel.delete');
    });
    Route::group(['prefix' => '/total-message'], function () {
        Route::get('/', [TotalmessageController::class, 'index'])->name('admin.total.message');
        Route::get('/get/list', [TotalmessageController::class, 'getList'])->name('admin.total.message.get.list');
        Route::post('/store', [TotalmessageController::class, 'store'])->name('admin.total.message.store');
        Route::get('/edit', [TotalmessageController::class, 'edit'])->name('admin.total.message.edit');
        Route::any('/update', [TotalmessageController::class, 'update'])->name('admin.total.message.update');
        Route::get('/delete', [TotalmessageController::class, 'delete'])->name('admin.total.message.delete');
    });
    Route::group(['prefix' => '/payment-request'], function () {
        Route::get('/', [PaymentrequestController::class, 'index'])->name('admin.payment.request');
        Route::get('/get/list', [PaymentrequestController::class, 'getList'])->name('admin.payment.request.get.list');
        Route::post('/store', [PaymentrequestController::class, 'store'])->name('admin.payment.request.store');
        Route::get('/edit', [PaymentrequestController::class, 'edit'])->name('admin.payment.request.edit');
        Route::any('/update', [PaymentrequestController::class, 'update'])->name('admin.payment.request.update');
        Route::get('/delete', [PaymentrequestController::class, 'delete'])->name('admin.payment.request.delete');
    });
    Route::group(['prefix' => '/tafsir'], function () {
        Route::get('/', [TafsirController::class, 'index'])->name('admin.tafsir');
        Route::get('/get/list', [TafsirController::class, 'getList'])->name('admin.tafsir.get.list');
        Route::post('/store', [TafsirController::class, 'store'])->name('admin.tafsir.store');
        Route::get('/edit', [TafsirController::class, 'edit'])->name('admin.tafsir.edit');
        Route::any('/update', [TafsirController::class, 'update'])->name('admin.tafsir.update');
        Route::get('/delete', [TafsirController::class, 'delete'])->name('admin.tafsir.delete');
    });
    Route::group(['prefix' => '/all-user'], function () {
        Route::get('/', [AlluserController::class, 'index'])->name('admin.all.user');
        Route::get('/get/list', [AlluserController::class, 'getList'])->name('admin.all.user.get.list');
        Route::post('/store', [AlluserController::class, 'store'])->name('admin.all.user.store');
        Route::get('/edit', [AlluserController::class, 'edit'])->name('admin.all.user.edit');
        Route::any('/update', [AlluserController::class, 'update'])->name('admin.all.user.update');
        Route::get('/delete', [AlluserController::class, 'delete'])->name('admin.all.user.delete');
    });
    Route::group(['prefix' => '/paid-user'], function () {
        Route::get('/', [PaiduserController::class, 'index'])->name('admin.paid.user');
        Route::get('/get/list', [PaiduserController::class, 'getList'])->name('admin.paid.user.get.list');
        Route::post('/store', [PaiduserController::class, 'store'])->name('admin.paid.user.store');
        Route::get('/edit', [PaiduserController::class, 'edit'])->name('admin.paid.user.edit');
        Route::any('/update', [PaiduserController::class, 'update'])->name('admin.paid.user.update');
        Route::get('/delete', [PaiduserController::class, 'delete'])->name('admin.paid.user.delete');
    });
    Route::group(['prefix' => '/custom-ads'], function () {
        Route::get('/', [CustomadsController::class, 'index'])->name('admin.custom.ads');
        Route::get('/get/list', [CustomadsController::class, 'getList'])->name('admin.custom.ads.get.list');
        Route::post('/store', [CustomadsController::class, 'store'])->name('admin.custom.ads.store');
        Route::get('/edit', [CustomadsController::class, 'edit'])->name('admin.custom.ads.edit');
        Route::any('/update', [CustomadsController::class, 'update'])->name('admin.custom.ads.update');
        Route::get('/delete', [CustomadsController::class, 'delete'])->name('admin.custom.ads.delete');
    });
    Route::group(['prefix' => '/transaction-history'], function () {
        Route::get('/', [TransactionHistoryController::class, 'index'])->name('admin.transaction.history');
        Route::get('/get/list', [TransactionHistoryController::class, 'getList'])->name('admin.transaction.history.get.list');
        Route::post('/store', [TransactionHistoryController::class, 'store'])->name('admin.transaction.history.store');
        Route::get('/edit', [TransactionHistoryController::class, 'edit'])->name('admin.transaction.history.edit');
        Route::any('/update', [TransactionHistoryController::class, 'update'])->name('admin.transaction.history.update');
        Route::get('/delete', [TransactionHistoryController::class, 'delete'])->name('admin.transaction.history.delete');
    });
});

Route::get('admin/logout', [LoginController::class, 'logout'])->name('admin.logout');


// admin route end


// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END
