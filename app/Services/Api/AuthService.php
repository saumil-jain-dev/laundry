<?php

namespace App\Services\Api;

use App\Http\Resources\Api\Auth\LoginRegisterResource;
use App\Http\Resources\Api\Auth\VerificationResource;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserDevice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService {

    public function register($request){

        $userStore = User::create($request->all());
        return $userStore;
    }

    public function login($request) {

        $userData = User::where('email',$request->email)->where('role_id',$request->role_id)->where('status',1)->whereNull('deleted_at')->first();
        if($userData){
            if(Hash::check($request->password, $userData->password)){
                Auth::login($userData);
                // Generate token and store in user object
                $tokenobj = $userData->createToken(env('APP_NAME'));
                $userData->access_token = $tokenobj->plainTextToken;

                // Revoke other tokens
                // $this->revokeOtherTokens($tokenobj->accessToken->id);
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
                // return response()->json(new VerificationResource($userData));

            } else {
                return false;
            }
        }

    }

    /**
     * Revoke other user tokens.
     *
     * @param  int  $currentTokenId
     * @return void
     */
    private function revokeOtherTokens($currentTokenId)
    {

        DB::table('personal_access_tokens')
        ->where('id', '!=', $currentTokenId)
        ->delete();
    }

    public function getProfile(){
        $user = Auth::user();
        return new LoginRegisterResource($user);
    }

    Public function updateProfile($request,$id) {

        $user = User::find($id);
        $data = $request->all();
        $profile_picture = $user->profile_picture;
        if($request->hasFile('profile_picture')){
            $profile_picture = uploadImage($request->file('profile_picture'),'profile_picture/'.$user->id);
        }
        $data['profile_picture'] = $profile_picture;

        $updateUser = $user->update($data);

        return $this->userFind($id);
    }

    public function userFind($id)
    {
        return User::find($id);
    }

    public function changePassword($request) {
        $id = Auth::user()->id;
        $user = User::find($id);
        $updatePassword = $user->password = Hash::make($request->new_password);
        $user->save();

        return $this->userFind($user->id);
    }

    public function getAddress($request) {
        $perPage = $request->input('per_page', 10);
        $userId = Auth::user()->id;
        $userAddress = UserAddress::where('user_id',$userId)->where('status',1)->orderBy('id','DESC')->paginate($perPage)->withQueryString();
        return $userAddress;
    }

    public function storeAddress($request) {
        $userId = Auth::user()->id;
        $data = $request->all();
        $data['user_id'] = $userId;
        $userAddressData = UserAddress::where('user_id', $userId)->where('is_default', 1)->first();
        $is_default = ($userAddressData) ? 0 : 1;
        $data['is_default'] = $is_default;

        $userAddress = UserAddress::create($data);

        return $userAddress;
    }

    public function addressDetails($request) {

        $userId = Auth::user()->id;
        $addressData = UserAddress::where('id',$request->address_id)->where('user_id',$userId);
        return $addressData;
    }

    public function updateAddress($request) {
        $addressData = UserAddress::find($request->address_id);
        $addressData->update($request->all());
        $updateData = UserAddress::find($request->address_id);
        return $updateData;
    }

    public function updateAddressmarkAsDefault($request) {
        $userId = Auth::user()->id;
        $addressData = UserAddress::where('id',$request->address_id)->where('user_id',$userId)->first();
        if($addressData) {
            UserAddress::where('user_id',$userId)->update(['is_default' => 0]);
            $addressData->update(['is_default' => 1]);
        }
        $addressData = UserAddress::find($request->address_id);
        return $addressData;
    }

    public function destroyAddress($request){
        $userId = Auth::user()->id;
        return UserAddress::where('id',$request->address_id)->where('user_id',$userId)->delete();
    }

    public function logout(){

        $user = Auth::user();
        DB::table('personal_access_tokens')
        ->where('tokenable_id', $user->id)
        ->delete();
        UserDevice::where('user_id',$user->id)->delete();

        return true;
    }

    public function deleteAccount(){
        $user = Auth::user();
        DB::table('personal_access_tokens')
        ->where('tokenable_id', $user->id)
        ->delete();
        UserDevice::where('user_id',$user->id)->delete();
        User::find($user->id)->delete();
        return true;
    }
}
