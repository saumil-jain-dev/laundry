<?php

use App\Http\Controllers\Api\Customer\Auth\LoginController;
use App\Http\Controllers\Api\Customer\Auth\RegisterController;
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

        Route::middleware('auth:sanctum')->group( function () {

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
