<?php

namespace App\Http\Controllers\Api\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\LoginRequest;
use App\Http\Resources\Api\Auth\LoginRegisterResource;
use App\Services\Api\AuthService;
use Exception;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    //

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request) {

        try {
            $user = $this->authService->login($request);
            if ($user) {
                return success(new LoginRegisterResource($user), trans('messages.login_success'), config('code.SUCCESS_CODE'));
            } else {
                return fail([], trans('messages.login_invalid'), config('code.EXCEPTION_ERROR_CODE'));
            }
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

}
