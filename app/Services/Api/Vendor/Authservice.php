<?php

namespace App\Services\Api\Vendor;

use App\Http\Resources\Api\Auth\Vendor\VerificationResource;
use App\Models\BusinessDetail;
use App\Models\BusinessType;
use App\Models\Category;
use App\Models\PriceType;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService {

    public function register($request){

        // dD($request->all());
        $userStore = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);

        $media = [];
        if($request->hasFile('media')){
            $media = uploadMultipleImages($request->file('media'), 'media/'.$userStore->id);

        }

        $businesDetails = BusinessDetail::create([
            'user_id' => $userStore->id,
            'business_name' => $request->business_name,
            'business_type_id' => $request->business_type_id,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2 ?? NULL,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zipcode' => $request->zipcode,
            'lattitude' => $request->lattitude,
            'longitude' => $request->longitude,
            'about' => $request->about,
            'media' => json_encode($media),
            'store_timings' => json_encode($request->store_timings),
            'pricing' => $request->pricing ? json_encode($request->pricing) : NULL,
            'is_verified' => 1,

        ]);
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

    public function getCategory($request) {

        $perPage = $request->input('per_page', 10);
        $categories = Category::active()->whereNull('parent')->with('subcategories')->paginate($perPage)->withQueryString();
        return $categories;
    }
}
