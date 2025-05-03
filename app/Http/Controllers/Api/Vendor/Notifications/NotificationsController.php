<?php

namespace App\Http\Controllers\Api\Vendor\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Api\Vendor\Authservice;
use Exception;

class NotificationsController extends Controller
{
    //
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
}
