<?php

use App\Http\Controllers\Api\Customer\Auth\LoginController;
use App\Http\Controllers\Api\Customer\Auth\RegisterController;
use App\Http\Controllers\Api\Customer\Auth\UserController;
use App\Http\Controllers\Api\Vendor\Auth\RegisterController As VendorRegister;
use App\Http\Controllers\Api\Vendor\Auth\Logincontroller As VendorLogin;
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

        Route::middleware('auth:sanctum')->group( function (): void {
            Route::post('delete-account',[UserController::class, 'deleteAccount']);
            Route::post('logout',[UserController::class, 'logout']);
            //Profile Route
            Route::prefix('pofile')->group(function(){
                Route::get('view',[UserController::class, 'getProfile']);
                Route::post('update',[UserController::class, 'updateProfile']);
            });

            //Address Route
            Route::prefix('address')->group(function(){
                Route::get('/',[UserController::class, 'getAddress']);
                Route::post('add',[UserController::class, 'storeAddress']);
                Route::post('edit',[UserController::class, 'editAddress']);
                Route::post('update',[UserController::class, 'updateAddress']);
                Route::post('mark-as-default',[UserController::class, 'updateAddressmarkAsDefault']);
                Route::post('delete',[UserController::class, 'destroyAddress']);
            });

            //Change Password
            Route::post('change-password',[UserController::class, 'changePassword']);
        });
    });

    //Vendor Routes
    Route::prefix('vendor')->group(function(){
        Route::get('business-type', [VendorRegister::class, 'getBusinessType']);
        Route::get('services', [VendorRegister::class, 'getServices']);
        Route::get('price-type', [VendorRegister::class, 'getPriceType']);
        Route::get('category', [VendorRegister::class, 'getCategory']);

        Route::post('register', [VendorRegister::class, 'register']);
        Route::post('login',[VendorLogin::class, 'login']);
    });
});
