<?php

namespace App\Http\Resources\Api\Customer\Home;

use App\Models\BookMark;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userId = $request->user_id;
        $deviceId = $request->device_id;
        $businessId = $this->business_id;

        $isBookmark = BookMark::where(function ($query) use ($userId, $deviceId, $businessId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('device_id', $deviceId);
                }
                $query->where('business_id', $businessId);
            })
            ->exists();
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'device_id' => $this->device_id,
            'user_id' => $this->user_id,
            'business_id' => $this->business_id,
            'viewed_at' => $this->viewed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'business_image' => getImage($this->business->business_image),
            'business_name' => $this->business->business_name,
            'business_type' =>optional($this->business->businessType)->name,
            'address_line_1' => optional($this->business)->address_line_1,
            'address_line_2' => optional($this->business)->address_line_2,
            'city' => optional($this->business)->city,
            'state' => optional($this->business)->state,
            'country' => optional($this->business)->country,
            'zipcode' => optional($this->business)->zipcode,
            'lattitude' => optional($this->business)->lattitude,
            'longitude' => optional($this->business)->longitude,
            'store_timings' => json_decode(optional($this->business)->store_timings),
            'ratting' => $this->business->averageRating->avg_rating ?? "0.00",
            'is_bookmark' => $isBookmark ? 1 : 0,
        ];
    }
}
