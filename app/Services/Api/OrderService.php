<?php

namespace App\Services\Api;

use App\Http\Resources\Api\Customer\Home\BusinessResource;
use App\Http\Resources\Api\Customer\Home\ServiceListResource;
use App\Models\BookMark;
use App\Models\BusinessDetail;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\RecentView;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class OrderService {

    public function orderCreate($request) {
        $data = $request->all();
        $order = Order::create([
            'user_id' => $data['user_id'],
            'business_id' => $data['business_id'],
            'total_amount' => $data['total_amount'],
            'gross_amount' => $data['gross_amount'] ?? NULL,
            'discount_amount' => $data['discount_amount'] ?? NULL,
            'diccount_id' => $data['diccount_id'] ?? NULL,
            'coupon_code' => $data['coupon_code'] ?? NULL,
            'pickup_date_time' => $data['pickup_date_time'] ?? NULL,
            'drop_date_time' => $data['drop_date_time'] ?? NULL,
            'address' => $data['address'],
            "customer_notes" => $data['customer_notes'] ?? NULL,
        ]);

        foreach ($data['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'business_id' => $data['business_id'],
                'service_id' => $item['service_id'],
                'category' => $item['category'],
                'item_name' => $item['item_name'],
                'unit_type' => $item['unit_type'],
                'quantity' => $item['quantity'],
                'price_per_unit' => $item['price_per_unit'],
                'total_price' => $item['total_price']
            ]);
        }

        $transaction = Transaction::create([
            'order_id' =>$order->id,
            'user_id' => $data['user_id'],
            'payment_method' => $data['payment_method'],
            'transaction_status' => $data['transaction_status'],
            'transaction_id' => $data['transaction_id'] ?? NULL,
            'transaction_response' => $data['transaction_response'] ? json_encode($data['transaction_response']) : NULL,
            'amount' => $data['total_amount']
        ]);
    }

}
