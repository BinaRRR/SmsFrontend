<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AttachJwtToken
{
    private $apiBaseUrl = env('API_URL');
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->isAspNetApiRequest($request)) {
            return $next($request);
        }

        $token = session('jwt_token');
        if ($token) {
            $request->headers->set('Authorization', 'Bearer ' . $token);
        }

        $response = $next($request);
        if ($response->getStatusCode() === 401 && Auth::check()) {
            if ($this->refreshToken()) {
                $request->headers->set('Authorization', 'Bearer ' . session('jwt_token'));
                return $next($request);
            } else {
                Auth::logout();
                session()->forget('jwt_token');
                return redirect('/login')->withErrors(['error' => 'Sesja wygasła. Zaloguj się ponownie.']);
            }
        }
    }

    private function isAspNetApiRequest(Request $request) {
        return $request->isJson() && str_starts_with($request->url(), $this->apiBaseUrl);
    }

    private function refreshToken() {
        $user = Auth::user();
        
    }
}
