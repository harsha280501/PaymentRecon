<?php

namespace App\Http\Middleware;

use App\Models\UserLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginLoggingMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        $pattern = '/\b(login|logout)\b/i';
        $url = $request->url();
        $ip = $request->ip();
        $response = $next($request);

        if ($response->isSuccessful() && preg_match($pattern, $url) && auth()->check()) {
            $user = auth()->user() ?? $request->user();

            UserLog::create([
                "userUID" => $user->userUID,
                'type' => 'LOGIN',
                "logTime" => now(),
                "loginDuration" => null,
                "ipAddress" => $ip,
                "isActive" => 1,
                "createdDate" => now(),
                "modifiedDate" => null,
                "createdBy" => '1',
            ]);
        }

        return $response;
    }
}