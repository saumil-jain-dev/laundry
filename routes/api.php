<?php

use App\Http\Controllers\Api\Customer\Auth\LoginController;
use App\Http\Controllers\Api\Customer\Auth\RegisterController;
use App\Http\Controllers\Api\Customer\Auth\UserController;
use App\Http\Controllers\Api\Customer\Home\HomeController;
use App\Http\Controllers\Api\Customer\Notifications\NotificationsController;
use App\Http\Controllers\Api\Customer\Order\OrderController;
use App\Http\Controllers\Api\Vendor\Auth\RegisterController As VendorRegister;
use App\Http\Controllers\Api\Vendor\Auth\Logincontroller As VendorLogin;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {

    //Customer Routes
    Route::prefix('customer')->group(function(){
        Route::post('register', [RegisterController::class, 'register']);
        Route::post('login',[LoginController::class, 'login']);

        //Home Route
        Route::controller(HomeController::class)->group(function () {
            // Recent View Routes
            Route::prefix('recent-view')->group(function () {
                Route::post('add', 'storeRecentView');
                Route::post('/', 'getRecentViewList');
            });

            //Bookmark Routes
            Route::prefix('bookmark')->group(function () {
                Route::post('add', 'storeBookmark');
                Route::post('/', 'getBookmarkList');
                Route::post('delete', 'destroyBookmark');
            });

            // Service Routes
            Route::post('service', 'getServiceList');
            Route::post('service-business-list', 'getServiceBusinessList');
            Route::post('business-details', 'getBusinessDetails');
            Route::post('most-popular', 'getMostPopularBusinessList');
            Route::post('search','getSearchBusinessList');
            Route::post('offers', 'getOffersList');
            Route::post('near-by-me', 'getNearBymeList');
        });

        Route::middleware('auth:sanctum')->group( function (): void {
            //Address Route
            Route::controller(UserController::class)->group(function () {
                // Address Routes
                Route::prefix('address')->group(function () {
                    Route::post('/', 'getAddress');
                    Route::post('add', 'storeAddress');
                    Route::post('edit', 'editAddress');
                    Route::post('update', 'updateAddress');
                    Route::post('mark-as-default', 'updateAddressmarkAsDefault');
                    Route::post('delete', 'destroyAddress');
                });

                //Profile Route
                Route::prefix('profile')->group(function () {
                    Route::get('view', 'getProfile');
                    Route::post('update', 'updateProfile');
                });

                // Other User Actions
                Route::post('add-help-center-message', 'storeHelpCenterMessage');
                Route::post('add-feedback', 'storeFeedback');
                Route::post('delete-account', 'deleteAccount');
                Route::post('logout', 'logout');

                //Change Password
                Route::post('change-password','changePassword');
            });

            //Order Route
            Route::controller(OrderController::class)->group(function () {
                Route::prefix('order')->group(function () {
                    Route::post('create', 'orderCreate');
                    Route::post('list', 'getOrderList');
                    Route::post('details', 'getOrdeDetails');
                });
                //Payment history
                Route::post('payment-history', 'getPaymentHistory');
            });

            //Notification Route
            Route::controller(NotificationsController::class)->group(function () {
                Route::prefix('notification')->group(function () {
                    Route::post('list','getNotificationList');
                    Route::post('mark-read', 'markReadNotification');
                    Route::post('delete', 'deleteNotification');
                });
            });

        });
    });

    //Vendor Routes
    Route::prefix('vendor')->group(function(){
        Route::controller(VendorRegister::class)->group(function () {
            Route::post('business-type', 'getBusinessType');
            Route::post('services', 'getServices');
            Route::post('price-type', 'getPriceType');
            Route::post('category', 'getCategory');
            Route::post('register', 'register');
        });
        Route::post('login',[VendorLogin::class, 'login']);
    });
});
