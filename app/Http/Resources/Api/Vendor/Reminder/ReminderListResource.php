<?php

namespace App\Http\Resources\Api\Vendor\Reminder;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReminderListResource extends JsonResource
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
            'type' => ucfirst($this->type),
            'date' => $this->reminder_date_time->format('d/m/Y'),
            'time' => $this->reminder_date_time->format('H:i a'),
            'status' => (bool) $this->status,
            'customer_name' => $this->order->customer->first_name . ' ' . $this->order->customer->last_name,
            'email' => $this->order->customer->email ?? null,
            'phone' => $this->order->customer->phone ?? null,
            'address' => $this->order->address,
        ];
    }
}
