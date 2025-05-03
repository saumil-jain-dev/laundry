<?php

namespace App\Services\Api\Vendor;

use App\Http\Resources\Api\Customer\Home\BusinessResource;
use App\Http\Resources\Api\Customer\Home\ServiceListResource;
use App\Models\BookMark;
use App\Models\BusinessDetail;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RecentView;
use App\Models\Reminders;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class OrderService {

    public function getOrderList($request){
        $vendorId = Auth::user()->id;
        $perPage = $request->input('per_page', 10);
        $orders = Order::with('orderItems')
            ->where('business_id', Auth::user()->id)
            ->whereDate('created_at', $request->date)
            ->orderBy('created_at', 'desc') // Order by latest
            ->paginate($perPage)->withQueryString();
        return $orders;
    }

    public function getPaymentHistory($request){
        $perPage = $request->input('per_page', 10);
        $transactions = Transaction::with(['order'])->whereHas('order',function($query){
            $query->where('business_id', Auth::user()->id);
        })
        ->orderBy('created_at', 'desc')
        ->paginate($perPage)->withQueryString();

        return $transactions;

    }

    public function getOrdeDetails($request) {
        $orderId = $request->order_id;
        $orderDetails = Order::with(['orderItems', 'customer','transaction'])
        ->where('id', $orderId)
        ->where('business_id', Auth::user()->id)
        ->firstOrFail();

        return $orderDetails;
    }

    public function updateOrderStatus($request){
        $orderId = $request->order_id;
        $action = $request->action;
        $cancel_reason = $request->cancel_reason;

        $order = Order::find($orderId);
        if($order){
            $order->status = $action;
            if($action == 'canceled'){
                $order->cancel_reason = $cancel_reason;
            }
            $order->save();
            return true;
        } else {
            return false;
        }
    }

    public function storeReminder($request){
        $reminder = Reminders::create([
            'order_id' => $request->order_id,
            'business_id' => Auth::user()->id,
            'type' => $request->type,
            'reminder_date_time' => $request->reminder_date_time,
        ]);

        return $reminder;
    }

    public function getReminderList($request) {
        $perPage = $request->input('per_page', 10);
        $query = Reminders::with(['order','order.customer'])
        ->where('business_id', Auth::user()->id);
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        $reminders = $query->orderBy('reminder_date_time','desc')->paginate($perPage)->withQueryString();

        return $reminders;
    }

    public function updateReminderStatus($request){
        $reminder =  Reminders::where('id', $request->reminder_id)
        ->where('business_id', Auth::user()->id)
        ->first();
        if(!$reminder){
            return false;
        }
        $reminder->status = $request->status;
        $reminder->save();

        return $reminder;
    }

    public function destroyReminder($request){
        $reminder = Reminders::where('id', $request->reminder_id)->where('business_id', Auth::user()->id)
        ->first();
        if(!$reminder){
            return false;
        }
        $reminder->delete();
        return $reminder;
    }


}
