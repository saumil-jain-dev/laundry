<?php

namespace App\Http\Resources\Api\Auth\Vendor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class VerificationResource extends JsonResource
{
     /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $tokenobj = $this->createToken(env('APP_NAME'));
        $this->revokeOtherTokens($tokenobj->accessToken->id);

        return array_merge(parent::toArray($request), [
            'access_token' => $tokenobj->plainTextToken
        ]);
    }

    /**
     * Revoke other user tokens.
     *
     * @param  int  $currentTokenId
     * @return void
     */
    private function revokeOtherTokens($currentTokenId)
    {

        DB::table('personal_access_tokens')
        ->where('id', '!=', $currentTokenId)
        ->delete();
    }
}
