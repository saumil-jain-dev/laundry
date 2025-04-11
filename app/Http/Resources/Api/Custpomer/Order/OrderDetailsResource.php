<?php

namespace App\Http\Resources\Api\Custpomer\Order;

use App\Http\Resources\Api\Customer\Home\BusinessResource;
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
            'id' => $this->id,
            'order_number' => $this->order_number,
            'user_id' => $this->user_id,
            'business_id' => $this->business_id,

            'total_amount' => $this->total_amount,
            'gross_amount' => $this->gross_amount,
            'discount_amount' => $this->discount_amount,
            'coupon_code' => $this->coupon_code,
            'pickup_date_time' => $this->pickup_date_time,
            'drop_date_time' => $this->drop_date_time,
            'address' => $this->address,
            'customer_notes' => $this->customer_notes,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'orderItems' => $this->orderItems,
            'business' => new BusinessResource($this->business),

        ];
    }
}
