<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SsUserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this['user']->id,
            'name' => $this['user']->name,
            'email' => $this['user']->email,

            'token' => [
                'access_token' => $this['access_token'],
                'refresh_token' => $this['refresh_token'],
                'expires_at' => $this['expires_at'],
                'token_type' => 'Bearer',
            ],
        ];
    }
}
