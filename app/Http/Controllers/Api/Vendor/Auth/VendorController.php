<?php

namespace App\Http\Controllers\Api\Vendor\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Vendor\ChangePasswordRequest;
use App\Http\Requests\Api\Vendor\UpdateProfileRequest;
use App\Http\Resources\Api\Vendor\Auth\LoginRegisterResource;
use Illuminate\Http\Request;
use App\Services\Api\Vendor\Authservice;
use Exception;

class VendorController extends Controller
{
    //
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function getProfile(Request $request) {

        try{
            $user = $this->authService->getProfile();
            return success($user, trans('messages.view',['attribute'=>'Profile']), config('code.SUCCESS_CODE'));
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try{
            $user = $this->authService->getProfile();
            if(is_null($user)){
                return fail([], trans('messages.not_found', ['attribute' => 'User']), config('code.NO_RECORD_CODE'));
            }

            $updatedData = $this->authService->updateProfile($request,$user->id);
            return success(new LoginRegisterResource($updatedData), trans('messages.update',['attribute'=>'Profile']), config('code.SUCCESS_CODE'));
        }catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function deleteAccount() {
        try {
            $user = $this->authService->deleteAccount();
            return success([], trans('messages.delete_account'), config('code.SUCCESS_CODE'));
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function logout() {
        try {
            $user = $this->authService->logout();
            return success([], trans('messages.logout_success'), config('code.SUCCESS_CODE'));
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    Public function changePassword(ChangePasswordRequest $request){
        try{

            $changePassword = $this->authService->changePassword($request);
            return success(new LoginRegisterResource($changePassword), trans('messages.update',['attribute'=>'Password']), config('code.SUCCESS_CODE'));
        }catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }
}
