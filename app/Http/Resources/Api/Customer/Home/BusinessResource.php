<?php

namespace App\Http\Resources\Api\Customer\Home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
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
            'business_image' => getImage($this->business_image),
            'business_name' => $this->business_name,
            'business_type' =>optional($this->businessType)->name,
            'address_line_1' => $this->address_line_1,
            'address_line_2' => $this->address_line_2,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'zipcode' => $this->zipcode,
            'lattitude' => $this->lattitude,
            'longitude' => $this->longitude,
            'store_timings' => json_decode($this->store_timings),
            'ratting' => $this->business->averageRating->avg_rating ?? 0,
        ];
    }
}
