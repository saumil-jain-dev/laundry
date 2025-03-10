<?php

namespace App\Http\Resources\Api\Customer\Home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessDetailsResource extends JsonResource
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
            'about' => $this->about,
            'services'    => $this->services->map(function ($service) {

                return [
                    'id'   => $service->id,
                    'name' => $service->name,
                ];
            }),
            'media' => collect(json_decode($this->media, true) ?: [])
            ->map(fn($file) => getImage($file))
            ->toArray(),
            'address_line_1' => $this->address_line_1,
            'address_line_2' => $this->address_line_2,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'zipcode' => $this->zipcode,
            'lattitude' => $this->lattitude,
            'longitude' => $this->longitude,
            'store_timings' => json_decode($this->store_timings),
            'pricing' => !empty($this->pricing) ? json_decode($this->pricing) : null,
            'status' => $this->status,
            'is_verified' => $this->is_verified,
            'ratting' => $this->business->averageRating->avg_rating ?? 0,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
