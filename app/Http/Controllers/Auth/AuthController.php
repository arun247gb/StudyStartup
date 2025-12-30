<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\SsUserResource;
use App\Models\SsUser;
use App\Enums\TokenAbility;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\TokenResource;
use App\Models\SsOrganization;
use App\Services\AuthService;
use Doctrine\Common\Lexer\Token;
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
            SsUserResource::make($tokenData),
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
            SsUserResource::make($tokenData),
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

        if ( !$token || !$token->can(TokenAbility::REFRESH_API->value)) {
            
            return response()->unauthorized('Invalid refresh token');
        }

        if ($token->expires_at && $token->expires_at->isPast()) {
            $token->delete();
            return response()->unauthorized('Refresh token expired. Please login again.');
        }

        $user = $token->tokenable;

        $user->tokens()
            ->where('name', 'access_token')
            ->delete();

        $accessToken = $user->createToken(
            'access_token',
            [TokenAbility::ACCESS_API->value],
            now()->addDay()
        );

        return response()->ok(
            TokenResource::make([
                'access_token' => $accessToken->plainTextToken,
                'refresh_token' => $refreshToken,
                'expires_at' => $accessToken->accessToken->expires_at,
            ]),
            'Token created successfully'
        );
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->ok(['message' => 'Logged out']);
    }
}
