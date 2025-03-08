<?php

namespace App\Http\Resources\Api\Auth\Vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginRegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'profile_picture' => getImage($this->profile_picture), // Call helper function
            'status' => $this->businessDetails->status,
            'role_id' => $this->role_id,
            'access_token' => $this->when($this->access_token, $this->access_token),
            'business_name' =>optional($this->businessDetails)->business_name,
            'business_image' => getImage($this->businessDetails->business_image),
            'business_type' =>optional($this->businessDetails->businessType)->name,
            'services'    => $this->businessDetails->services->map(function ($service) {
                return [
                    'id'   => $service->id,
                    'name' => $service->name,
                ];
            }),
            'media' => collect(json_decode(optional($this->businessDetails)->media, true) ?: [])
            ->map(fn($file) => getImage($file))
            ->toArray(),
            'address_line_1' => optional($this->businessDetails)->address_line_1,
            'address_line_2' => optional($this->businessDetails)->address_line_2,
            'city' => optional($this->businessDetails)->city,
            'state' => optional($this->businessDetails)->state,
            'country' => optional($this->businessDetails)->country,
            'zipcode' => optional($this->businessDetails)->zipcode,
            'lattitude' => optional($this->businessDetails)->lattitude,
            'longitude' => optional($this->businessDetails)->longitude,
            'about' => optional($this->businessDetails)->about,
            'store_timings' => json_decode(optional($this->businessDetails)->store_timings),
            'pricing' => !empty($this->businessDetails->pricing) ? json_decode($this->businessDetails->pricing) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
