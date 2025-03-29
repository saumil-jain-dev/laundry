<?php

namespace App\Http\Controllers\Api\Customer\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Customer\OrderRequest;
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
}
