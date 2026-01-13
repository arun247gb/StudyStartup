<?php

namespace App\Http\Controllers;

use App\Models\SsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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
            config('services.clinasyst.token_url'),
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

        $localUser = SsUser::firstOrCreate(
            ['email' => $user['email']],
            ['name' => $user['name']]
        );

        Auth::login($localUser);
        // $request->session()->regenerate();
        return redirect()->to(config('services.frontend.dashboard_url'));

    }

    public function authorization(Request $request)
    {
        $state = Str::random(6);

        session([
            'oauth_state' => $state,
            'oauth_source' => $request->source,
        ]);

        return redirect()->away(
            "http://localhost:3000/auth/sso-login?" . http_build_query([
                'client_id'    => config('services.clinasyst.client_id'),
                'redirect_uri' => config('services.clinasyst.redirect_uri'),
                'response_type' => 'code',
                'state'        => $state,
                'source'       => $request->source,
            ])
        );
    }
}
