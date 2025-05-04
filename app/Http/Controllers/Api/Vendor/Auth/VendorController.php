<?php

namespace App\Http\Controllers\Api\Vendor\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Vendor\ChangePasswordRequest;
use App\Http\Requests\Api\Vendor\FeedbackRequest;
use App\Http\Requests\Api\Vendor\HelpCenterRequest;
use App\Http\Requests\Api\Vendor\UpdateBusinessDetailsRequest;
use App\Http\Requests\Api\Vendor\UpdatePriceRequest;
use App\Http\Requests\Api\Vendor\UpdateProfileRequest;
use App\Http\Requests\Api\Vendor\UpdateTimingRequest;
use App\Http\Resources\Api\Vendor\Auth\LoginRegisterResource;
use App\Http\Resources\Api\Vendor\Business\BusinessDetailsResource;
use App\Http\Resources\Api\Vendor\Faq\FaqResource;
use App\Models\BusinessDetail;
use Illuminate\Http\Request;
use App\Services\Api\Vendor\Authservice;
use Exception;
use Illuminate\Support\Facades\Auth;

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
            return success($feedbackData,trans('messages.create',['attribute'=>'Feedback']));
        }  catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getVendorBusinessDetails(){
        try{
            $businessDetails = BusinessDetail::where('user_id',Auth::user()->id)->first();
            if($businessDetails){
                return success(new BusinessDetailsResource($businessDetails),trans('messages.view',['attribute'=>'Business details']));
            }else{
                return fail([], trans('messages.not_found', ['attribute' => 'Vendor Business']), config('code.NO_RECORD_CODE'));
            }
        }  catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }

    }

    public function updateStoreTiming(UpdateTimingRequest $request){
        try{
            $businessDetails = $this->authService->updateStoreTiming($request);
            return success(new BusinessDetailsResource($businessDetails),trans('messages.update',['attribute'=>'Business timeing']));
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function updatePricing(UpdatePriceRequest $request){
        try{
            $businessDetails = $this->authService->updatePricing($request);
            return success(new BusinessDetailsResource($businessDetails),trans('messages.update',['attribute'=>'Business price']));
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function updateBusinessDetails(UpdateBusinessDetailsRequest $request){
        try{
            $businessDetails = $this->authService->updateBusinessDetails($request);
            return success(new BusinessDetailsResource($businessDetails),trans('messages.update',['attribute'=>'Business details']));
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getFaqList(Request $request){
        try{

            $faqList = $this->authService->getFaqList($request);
            if($faqList){
                return success(
                    pagination(FaqResource::class, $faqList),
                    trans('messages.list', ['attribute' => 'Faq']),
                    config('code.SUCCESS_CODE')
                );
            }
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

}
