<?php

namespace App\Http\Resources\Api\Vendor\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'order_id' => $this->id,
            'order_number' => $this->order_number,
            'customer_name' => $this->customer->first_name . ' ' . $this->customer->last_name,
            'customer_email' => $this->customer->email,
            'customer_phone' => $this->customer->phone,
            'customer_address' => $this->address,
            'total_amount' => $this->total_amount,
            'transaction_type' => $this->transaction->payment_method,
            'transaction_status' => $this->transaction->transaction_status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'pickup_date_time' => $this->pickup_date_time,
            'drop_date_time' => $this->drop_date_time,
            'status' => $this->status,
            'cancel_reason' => $this->cancel_reason,
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),

        ];
    }
}
