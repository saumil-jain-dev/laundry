<?php

namespace App\Http\Controllers\Api\Vendor\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Vendor\NotificationRequest;
use App\Http\Resources\Api\Vendor\Notifications\NotificationsResource;
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

    public function getNotificationList(Request $request) {

        try{
            $notificationList = $this->authService->getNotificationList($request);
            return success(pagination(NotificationsResource::class, $notificationList), trans('messages.list',['attribute'=>'Notifications']), config('code.SUCCESS_CODE'));
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function markReadNotification(NotificationRequest  $request) {
        try{
            $markReadNotification = $this->authService->markReadNotification($request);
            return success([], trans('messages.mark_read'), config('code.SUCCESS_CODE'));
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function deleteNotification(NotificationRequest  $request) {
        try{
            $deleteNotification = $this->authService->deleteNotification($request);
            return success([], trans('messages.deleted',['attribute' => 'Notification']), config('code.SUCCESS_CODE'));
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }
}
