<?php

namespace App\Http\Controllers\Api\Vendor\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Vendor\RegisterRequest;
use App\Http\Resources\Api\Auth\Vendor\LoginRegisterResource;
use App\Http\Resources\Api\Vendor\BusinessTypeResource;
use App\Http\Resources\Api\Vendor\PriceTypeResource;
use App\Services\Api\Vendor\AuthService;
use Illuminate\Http\Request;
use Exception;

class RegisterController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    //
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */

    public function register(RegisterRequest $request) {
        try{

            $vendor = $this->authService->register($request);
            return success(new LoginRegisterResource($vendor), trans('messages.register_success'), config('code.SUCCESS_CODE'));

        } catch (Exception $e){

            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }

    }

    public function getBusinessType(Request $request) {

        try{
            $businessType = $this->authService->getBusinessType($request);
            if($businessType){
                return success(
                    pagination(BusinessTypeResource::class, $businessType),
                    trans('messages.list', ['attribute' => 'Business type']),
                    config('code.SUCCESS_CODE')
                );
            }
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getPriceType(Request $request) {

        try{
            $priceType = $this->authService->getPriceType($request);
            if($priceType){
                return success(
                    pagination(PriceTypeResource::class, $priceType),
                    trans('messages.list', ['attribute' => 'Price type']),
                    config('code.SUCCESS_CODE')
                );
            }
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }
}
