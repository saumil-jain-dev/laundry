<?php

use App\Http\Controllers\Api\Customer\Auth\LoginController;
use App\Http\Controllers\Api\Customer\Auth\RegisterController;
use App\Http\Controllers\Api\Customer\Auth\RegisterController As VendorRegister;
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
            Route::get('products', [LoginController::class,'checkAccess']);
        });
    });

    //Vendor Routes
    Route::prefix('vendor')->group(function(){
        Route::post('register', [VendorRegister::class, 'register']);
    });
});
