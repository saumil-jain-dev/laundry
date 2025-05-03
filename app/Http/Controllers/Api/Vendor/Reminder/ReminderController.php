<?php

namespace App\Http\Controllers\Api\Vendor\Reminder;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Vendor\DeleteReminderRequest;
use App\Http\Requests\Api\Vendor\ReminderListRequest;
use App\Http\Requests\Api\Vendor\ReminderRequest;
use App\Http\Requests\Api\Vendor\ReminderStatusRequest;
use App\Http\Resources\Api\Vendor\Reminder\ReminderListResource;
use App\Models\Reminders;
use Illuminate\Http\Request;
use App\Services\Api\Vendor\OrderService;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    //
    protected $vendorOrderService;

    public function __construct(OrderService $vendorOrderService)
    {
        $this->vendorOrderService = $vendorOrderService;

    }

    public function storeReminder(ReminderRequest $request) {
        try{
            $exists = Reminders::where('order_id', $request->order_id)
                ->where('business_id', Auth::user()->id)
                ->where('type', $request->type)
                ->where('reminder_date_time', $request->reminder_date_time)
                ->exists();

            if ($exists) {
                return fail([], 'message Reminder already exists for the given order, type, and time.', config('code.FAILED_CODE'));

            }
            $reminder = $this->vendorOrderService->storeReminder($request);
            if($reminder){
                return success(
                    $request->all(),
                    trans('messages.create', ['attribute' => 'Reminder']),
                    config('code.SUCCESS_CODE')
                );
            }else{
                return fail([], 'Something went wrong', config('code.EXCEPTION_ERROR_CODE'));
            }
        } catch(Exception $e){
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getReminderList(ReminderListRequest $request){
        try {
            $reminderData = $this->vendorOrderService->getReminderList($request);
            if($reminderData){
                return success(
                    pagination(ReminderListResource::class, $reminderData),
                    trans('messages.list', ['attribute' => 'Order']),
                    config('code.SUCCESS_CODE')
                );
            }
        } catch(Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function updateReminderStatus(ReminderStatusRequest $request){
        try {
            $reminderData = $this->vendorOrderService->updateReminderStatus($request);
            if($reminderData){
                return success(
                    $request->all(),
                    trans('messages.update', ['attribute' => 'Reminder']),
                    config('code.SUCCESS_CODE')
                );
            }else{
                return fail([], trans('messages.not_found', ['attribute' => 'Reminder']), config('code.NO_RECORD_CODE'));
            }
        } catch(Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function destroyReminder(DeleteReminderRequest $request){
        try {
            $reminderData = $this->vendorOrderService->destroyReminder($request);
            if($reminderData){
                return success(
                    $request->all(),
                    trans('messages.deleted', ['attribute' => 'Reminder']),
                    config('code.SUCCESS_CODE')
                );
            }else{
                return fail([], trans('messages.not_found', ['attribute' => 'Reminder']), config('code.NO_RECORD_CODE'));
            }
        } catch(Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }
}
