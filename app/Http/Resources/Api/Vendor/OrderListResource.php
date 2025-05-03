<?php

namespace App\Http\Resources\Api\Vendor;

use App\Http\Resources\Api\Vendor\Order\OrderItemResource;
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
            'order_id' => $this->id,
            'order_number' => $this->order_number,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'pickup_date_time' => $this->pickup_date_time,
            'drop_date_time' => $this->drop_date_time,
            'status' => $this->status,
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
        ];
    }
}
