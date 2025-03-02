<?php

namespace App\Services\Api\Vendor;

use App\Http\Resources\Api\Auth\VerificationResource;
use App\Models\BusinessType;
use App\Models\PriceType;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService {

    public function register($request){

        $userStore = User::create($request->all());
        return $userStore;
    }

    public function login($request) {

        $userData = User::where('email',$request->email)->where('role_id',$request->role_id)->first();
        if($userData){
            if(Hash::check($request->password, $userData->password)){
                Auth::login($userData);
                UserDevice::updateOrCreate(
                    ['user_id' => $userData->id],
                    [
                        'device_id' => $request->device_id,
                        'device_type' => $request->device_type,
                        'device_token' => $request->device_token,
                        'os_version' => $request->os_version,
                        'app_version' => $request->app_version,
                        'device_name' => $request->device_name,
                        'model_name' => $request->model_name,
                        'status' => 1
                    ]
                );
                return new VerificationResource($userData);
            } else {
                return false;
            }
        }
    }

    public function getBusinessType($request) {

        $perPage = $request->input('per_page', 10);
        $businessType = BusinessType::where('status',1)->orderBy('id','DESC')->paginate($perPage)->withQueryString();
        return $businessType;
    }

    public function getPriceType($request) {

        $perPage = $request->input('per_page', 10);
        $priceType = PriceType::where('status',1)->orderBy('id','DESC')->paginate($perPage)->withQueryString();
        return $priceType;
    }
}
