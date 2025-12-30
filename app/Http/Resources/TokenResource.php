<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'access_token' => $this->resource['access_token'],
            'refresh_token' => $this->resource['refresh_token'],
            'token_type' => 'Bearer',
            'expires_at' => $this->resource['expires_at'],
        ];
    }
}
