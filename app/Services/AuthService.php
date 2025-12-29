<?php

namespace App\Services;

use App\Enums\TokenAbility;
use App\Models\SsUser;

class AuthService
{
    /**
     * Issue access & refresh tokens for a user
     */
    public function issueTokens(SsUser $user): array
    {
        // Revoke all previous tokens
        $user->tokens()->delete();

        $accessToken = $user->createToken(
            'access_token',
            [TokenAbility::ACCESS_API->value],
            now()->addMinutes(15)
        );

        $refreshToken = $user->createToken(
            'refresh_token',
            [TokenAbility::REFRESH_API->value],
            now()->addDays(30)
        );

        return [
            'access_token'  => $accessToken->plainTextToken,
            'expires_at'    => $accessToken->accessToken->expires_at,
            'refresh_token' => $refreshToken->plainTextToken,
            'token_type'    => 'Bearer',
            'user'          => $user,
        ];
    }
}
