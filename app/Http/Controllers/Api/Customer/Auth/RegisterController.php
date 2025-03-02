<?php

namespace App\Http\Controllers\Api\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\RegisterRequest;
use App\Http\Resources\Api\Auth\LoginRegisterResource;
use Exception;
use Illuminate\Http\Request;
use App\Services\Api\AuthService;

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

            $user = $this->authService->register($request);
            return success(new LoginRegisterResource($user), trans('messages.register_success'), config('code.SUCCESS_CODE'));
        } catch (Exception $e){
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }

    }
}
