<?php

namespace App\Http\Controllers\Api\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\AddressDetailsRequest;
use App\Http\Requests\Api\Customer\AddressRequest;
use App\Http\Requests\Api\Customer\ChangePasswordRequest;
use App\Http\Requests\Api\Customer\FeedbackRequest;
use App\Http\Requests\Api\Customer\HelpCenterRequest;
use App\Http\Requests\Api\Customer\UpdateAddressRequest;
use App\Http\Requests\Api\Customer\UpdateProfileRequest;
use App\Http\Resources\Api\Auth\LoginRegisterResource;
use App\Http\Resources\Api\Customer\Address\AddressResource;
use Exception;
use Illuminate\Http\Request;
use App\Services\Api\AuthService;

class UserController extends Controller
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

    Public function changePassword(ChangePasswordRequest $request){
        try{

            $changePassword = $this->authService->changePassword($request);
            return success(new LoginRegisterResource($changePassword), trans('messages.update',['attribute'=>'Password']), config('code.SUCCESS_CODE'));
        }catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getAddress(Request $request){
        try{

            $userAddress = $this->authService->getAddress($request);
            if($userAddress){
                return success(
                    pagination(AddressResource::class, $userAddress),
                    trans('messages.list', ['attribute' => 'User address']),
                    config('code.SUCCESS_CODE')
                );
            }
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function storeAddress(AddressRequest $request) {

        try {
            $userAddress = $this->authService->storeAddress($request);
            return success($userAddress,trans('messages.create',['attribute'=>'Address']));
        }  catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function editAddress(AddressDetailsRequest $request) {
        try {
            $userAddress = $this->authService->addressDetails($request);
            return success($userAddress,trans('messages.view',['attribute'=>'Address']));
        }  catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function updateAddress(UpdateAddressRequest $request) {
        try {
            $userAddress = $this->authService->updateAddress($request);
            return success($userAddress,trans('messages.update',['attribute'=>'Address']));
        }  catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function updateAddressmarkAsDefault(AddressDetailsRequest $request) {
        try {

            $userAddress = $this->authService->updateAddressmarkAsDefault($request);
            return success($userAddress,trans('messages.update',['attribute'=>'Address']));
        }  catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function destroyAddress(AddressDetailsRequest $request){
        try {
            $userAddress = $this->authService->addressDetails($request);
            if($userAddress){
                $this->authService->destroyAddress($request);
                return success([], trans('messages.deleted',['attribute' => 'Address']), config('code.SUCCESS_CODE'));
            } else {
                return fail([], trans('messages.not_found', ['attribute' => 'Address']), config('code.NO_RECORD_CODE'));
            }
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

    public function deleteAccount() {
        try {
            $user = $this->authService->deleteAccount();
            return success([], trans('messages.delete_account'), config('code.SUCCESS_CODE'));
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function storeHelpCenterMessage(HelpCenterRequest $request) {

        try {

            $data = $this->authService->storeHelpCenterMessage($request);
            return success($data,trans('messages.create',['attribute'=>'Help center message']));
        }  catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function storeFeedback(FeedbackRequest $request) {

        try {

            $feedbackData = $this->authService->storeFeedback($request);
            return success($feedbackData,trans('messages.create',['attribute'=>'Help center messahe']));
        }  catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }
}
