<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeader
{
    private function getHeaders(){
        return [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'DENY',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'permissions-policy' => 'geolocation=(), microphone=(), camera=()',
        ];

        if (app()->isProduction()) {
            $headers['Strict-Transport-Security'] = 'max-age=31536000; includeSubDomains; preload';
        }

        return $headers;
    }

    private function buildCsp(){
        $directives = [
                "default-src 'self'",
                "script-src 'self' 'unsafe-inline' 'unsafe-eval'",
                "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
                "font-src 'self' https://fonts.gstatic.com",
                "img-src 'self' data: blob:",
                "connect-src 'self'",
                "frame-ancestors 'none'",
                "base-uri 'self'",
                "form-action 'self'",
        ];

        $filtered = array_filter(
            $directives,
            fn(string $directive): bool => trim($directive) !== ''
        );

        return implode('; ', $directives);
    }
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        foreach($this->getHeaders() as $key => $value){
            if(! is_string($key) || ! is_string($value) || trim($value) === ''){
                continue;
            }
            $response->headers->set($key, $value);
        }

        $csp = $this->buildCsp();

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
