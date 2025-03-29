<?php

namespace App\Http\Resources\Api\Customer\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
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
            'ordered_date' => $this->created_at->format('d M, Y'),
            'order_number' => $this->order_number,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'items' => OrderItemResource::collection($this->orderItems),
            'created_at' => $this->created_at,
        ];
    }
}
