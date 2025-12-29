<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\SsUserResource;
use App\Models\SsUser;
use App\Enums\TokenAbility;
use App\Http\Requests\LoginRequest;
use App\Models\SsOrganization;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $organization = SsOrganization::create([
            'name'          => $request->input('organization_name'),
            'type'          => $request->input('organization_type'),
            'account_type'  => $request->input('organization_account_type'),
        ]);

        $user = SsUser::create([
            'name'             => $request->input('name'),
            'email'            => $request->input('email'),
            'password'         => Hash::make($request->input('password')),
            'ss_organization_id'  => $organization->id,
        ]);

        $tokenData = $this->authService->issueTokens($user);

        return response()->ok(
            new SsUserResource($tokenData),
            'User registered successfully'
        );
    }

    public function login(LoginRequest $request)
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->unauthorized('Invalid credentials');
        }

        $user = SsUser::where('email', $request->email)->firstOrFail();  
        if(!$user){
            throw ValidationException::withMessages([
                'email' => config('auth.invalid_user'),
            ]);
        }

        $tokenData = $this->authService->issueTokens($user);

        return response()->ok(
            new SsUserResource($tokenData),
            'User logged in successfully'
        );
    }


    public function refreshToken(Request $request)
    {
        $refreshToken = $request->bearerToken();

        if (!$refreshToken) {
            return response()->unprocessableContent('Refresh token missing');
        }

        $token = PersonalAccessToken::findToken($refreshToken);

        if (
            !$token ||
            !$token->can(TokenAbility::REFRESH_API->value)
        ) {
            return response()->unauthorized('Invalid refresh token');
        }

        // if ($token->expires_at && $token->expires_at->isPast()) {
        //     $token->delete();
        //     return response()->unauthorized('Refresh token expired');
        // }

        $user = $token->tokenable;

        $user->tokens()
            ->where('name', 'access_token')
            ->delete();

        $accessToken = $user->createToken(
            'access_token',
            [TokenAbility::ACCESS_API->value],
            now()->addMinutes(15)
        );

        return response()->json([
            'access_token' => $accessToken->plainTextToken,
            'expires_at' => $accessToken->accessToken->expires_at,
            'token_type' => 'Bearer',
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }

    public function issueTokens(SsUser $user)
    {

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
            'access_token' => $accessToken->plainTextToken,
            'expires_at' => $accessToken->accessToken->expires_at,
            'refresh_token' => $refreshToken->plainTextToken,
            'token_type' => 'Bearer',
            'user' => $user,
        ];
    }
}
