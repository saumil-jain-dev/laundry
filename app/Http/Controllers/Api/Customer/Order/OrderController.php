<?php

namespace App\Http\Controllers\Api\Customer\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\OrderDetailsRequest;
use App\Http\Requests\Api\Customer\OrderRequest;
use App\Http\Resources\Api\Customer\Order\OrderListResource;
use App\Http\Resources\Api\Customer\Order\PaymentHistoryResource;
use App\Http\Resources\Api\Custpomer\Order\OrderDetailsResource;
use Illuminate\Http\Request;
use Exception;
use App\Services\Api\OrderService;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function orderCreate(OrderRequest $request) {
        DB::beginTransaction();
        try{
            $reRecentView = $this->orderService->orderCreate($request);
            DB::commit();
            return success(
                $request->all(),
                trans('messages.create', ['attribute' => 'Order']),
                config('code.SUCCESS_CODE')
            );
        } catch (Exception $e) {
            DB::rollBack();
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getOrderList(Request $request){
        try {
            $orderData = $this->orderService->getOrderList($request);
            if($orderData){
                return success(
                    pagination(OrderListResource::class, $orderData),
                    trans('messages.list', ['attribute' => 'Order']),
                    config('code.SUCCESS_CODE')
                );
            }
        } catch(Exception $e){
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getPaymentHistory(Request $request){
        try {
            $paymentHistory = $this->orderService->getPaymentHistory($request);
            if($paymentHistory){
                return success(
                    pagination(PaymentHistoryResource::class, $paymentHistory),
                    trans('messages.list', ['attribute' => 'Payment History']),
                    config('code.SUCCESS_CODE')
                );
            }
        } catch(Exception $e){
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getOrdeDetails(OrderDetailsRequest $request){
        try{
            $orderDetails = $this->orderService->getOrdeDetails($request);
            if($orderDetails){
                return success(
                    new OrderDetailsResource($orderDetails),
                    trans('messages.view', ['attribute' => 'Order details']),
                    config('code.SUCCESS_CODE')
                );
            }else{
                return fail([], trans('messages.not_found', ['attribute' => 'Order']), config('code.NO_RECORD_CODE'));
            }
        } catch(Exception $e){
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

}
