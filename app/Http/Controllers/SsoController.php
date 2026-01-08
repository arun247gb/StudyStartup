<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use JmesPath\Env;

class SsoController extends Controller
{
    public function token(Request $request)
    {
        $response = Http::asForm()->post(
            config('services.main_app.token_url'),
            [
                'grant_type' => 'authorization_code',
                'client_id' => config('services.main_app.client_id'),
                'client_secret' => config('services.main_app.client_secret'),
                'redirect_uri' => config('services.main_app.redirect_uri'),
                'code' => $request->code,
            ]
        );

        return $response->json();
    }

    public function callback(Request $request)
    {

        $response = Http::asForm()->post(
            'http://clinasystng-backend-nginx/oauth/token',
            [
                'grant_type'    => 'authorization_code',
                'client_id'     => config('services.clinasyst.client_id'),
                'client_secret' => config('services.clinasyst.client_secret'),
                'redirect_uri'  => config('services.clinasyst.redirect_uri'),
                'code'          => $request->code,
            ]
        );

        $token = $response->json();

        $user = Http::withToken($token['access_token'])
            ->get('http://clinasystng-backend-nginx/user')
            ->json();

        return response()->ok([
            'token' => $token,
            'user' => $user,
        ]);
    }
}
