<?php

namespace App\Http\Resources\Api\Auth;

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
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'profile_picture' => getImage($this->profile_picture), // Call helper function
            'status' => $this->status,
            'role_id' => $this->role_id,
            'address' => $this->addresses,
            'access_token' => $this->when($this->access_token, $this->access_token),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
