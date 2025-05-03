<?php

namespace App\Http\Resources\Api\Vendor\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentHistoryResource extends JsonResource
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
            'order_id' => $this->order->id ?? null,
            'order_number' => $this->order->order_number ?? null,
            'payment_date' => $this->created_at->format('d-M-Y h:i A'),
            'total_amount' => $this->amount,
            'payment_method' => $this->payment_method,
            'transaction_status' => $this->transaction_status,
            'business_name' => $this->order->business->business_name ?? null,
            'created_at' => $this->created_at,

        ];
    }
}
