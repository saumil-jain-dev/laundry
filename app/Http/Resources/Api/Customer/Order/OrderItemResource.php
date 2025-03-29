<?php

namespace App\Http\Resources\Api\Customer\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'category' => $this->category,
            'item_name' => $this->item_name,
            'quantity' => $this->quantity,
            'price_per_unit' => $this->price_per_unit,
            'total_price' => $this->total_price,
        ];
    }
}
