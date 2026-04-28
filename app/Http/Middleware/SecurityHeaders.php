<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Adds HTTP security headers to every response:
 *   - X-Frame-Options          : blocks clickjacking
 *   - X-Content-Type-Options   : blocks MIME sniffing
 *   - X-XSS-Protection         : legacy browser XSS filter
 *   - Referrer-Policy          : limits referrer leakage
 *   - Permissions-Policy       : restricts browser features
 *   - Content-Security-Policy  : restricts resource origins
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(self), microphone=(), geolocation=()');

        // Content-Security-Policy — allows same-origin, Google Fonts,
        // CDN scripts (Lucide), and inline scripts needed by the app.
        // Adjust as you add third-party resources.
        // In local/dev, allow the debug logger endpoint (Cursor debug mode).
        // This is intentionally scoped to non-production to avoid weakening CSP in production.
        $debugConnectSrc = '';
        if (app()->environment('local', 'development', 'testing')) {
            $debugConnectSrc = ' http://127.0.0.1:7658';
        }

        $csp = implode('; ', [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' blob: http: https: https://unpkg.com https://cdn.jsdelivr.net",
            "worker-src 'self' blob:",
            "style-src 'self' 'unsafe-inline' http: https: https://fonts.googleapis.com https://cdn.jsdelivr.net",
            "font-src 'self' http: https: https://fonts.gstatic.com data:",
            "img-src 'self' http: https: data: blob:",
            "media-src 'self' blob:",
            "connect-src 'self'{$debugConnectSrc} https://unpkg.com https://cdn.jsdelivr.net",
            "frame-ancestors 'self'",
            "form-action 'self' http: https:",
            "base-uri 'self'",
        ]);

        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
