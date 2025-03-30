<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;

class ApiClient
{
    public static function request($method, $url, $data = [])
    {
        $fullUrl = env('API_URL') . $url;
        $token = session('jwt_token');

        $response = Http::withToken($token)->$method($fullUrl, $data);

        if ($response->status() === 401) {
            if (self::refreshToken()) {
                // Ponowne wysłanie zapytania po odświeżeniu tokena
                $newToken = session('jwt_token');
                return Http::withToken($newToken)->$method($fullUrl, $data);
            } else {
                Auth::logout(); // Refresh token wygasł → wylogowanie użytkownika
                return $response;
            }
        }

        return $response;
    }

    private static function refreshToken()
    {
        $refreshToken = Cookie::get('refresh_token');

        // dd($refreshToken);
        if (!$refreshToken) {
            return false;
        }

        $response = Http::post(env('API_URL') . '/auth/refresh-token', [
            'refreshToken' => $refreshToken,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            session(['jwt_token' => $data['token']]);

            return true;
        }

        return false;
    }
}