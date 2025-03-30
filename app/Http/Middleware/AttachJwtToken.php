<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class AttachJwtToken
{
    private string $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env("API_URL", "http://localhost:5202/api");
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isAspNetApiRequest($request)) {
            dd(str_starts_with($request->url(), $this->apiBaseUrl));
            $token = session('jwt_token');
            if ($token) {
                $request->headers->set('Authorization', 'Bearer ' . $token);
            }
        }

        return $next($request);
    }

    private function isAspNetApiRequest(Request $request) {
        return str_starts_with($request->url(), $this->apiBaseUrl);
    }
}
