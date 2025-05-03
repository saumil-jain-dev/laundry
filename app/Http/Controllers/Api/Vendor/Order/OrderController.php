<?php

namespace App\Http\Controllers\Api\Vendor\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Vendor\OrderDetailsRequest;
use App\Http\Requests\Api\Vendor\OrderRequest;
use App\Http\Requests\Api\Vendor\OrderStatusRequest;
use App\Http\Resources\Api\Vendor\Order\OrderDetailsResource;
use App\Http\Resources\Api\Vendor\Order\PaymentHistoryResource;
use App\Http\Resources\Api\Vendor\OrderListResource;
use Illuminate\Http\Request;
use App\Services\Api\Vendor\OrderService;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderController extends Controller
{
    //
    protected $vendorOrderService;

    public function __construct(OrderService $vendorOrderService)
    {
        $this->vendorOrderService = $vendorOrderService;

    }

    public function getOrderList(OrderRequest $request) {
        try {
            $orderData = $this->vendorOrderService->getOrderList($request);
            if($orderData){
                return success(
                    pagination(OrderListResource::class, $orderData),
                    trans('messages.list', ['attribute' => 'Order']),
                    config('code.SUCCESS_CODE')
                );
            }
        } catch (Exception $e) {
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getOrdeDetails(OrderDetailsRequest $request){
        try{
            $orderDetails = $this->vendorOrderService->getOrdeDetails($request);
            if($orderDetails){
                return success(
                    new OrderDetailsResource($orderDetails),
                    trans('messages.view', ['attribute' => 'Order details']),
                    config('code.SUCCESS_CODE')
                );
            }else{
                return fail([], trans('messages.no_record', ['attribute' => 'Order']), config('code.NO_RECORD_CODE'));
            }
        } catch(Exception $e){
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function updateOrderStatus(OrderStatusRequest $request){
        try{
            $orderDetails = $this->vendorOrderService->updateOrderStatus($request);
            if($orderDetails){
                return success(
                    $request->all(),
                    trans('messages.update', ['attribute' => 'Order status']),
                    config('code.SUCCESS_CODE')
                );
            }else{
                return fail([], 'Something went wrong', config('code.EXCEPTION_ERROR_CODE'));
            }
        } catch(Exception $e){
            return fail([], $e->getMessage(), config('code.EXCEPTION_ERROR_CODE'));
        }
    }

    public function getPaymentHistory(Request $request){
        try {
            $paymentHistory = $this->vendorOrderService->getPaymentHistory($request);
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


}
