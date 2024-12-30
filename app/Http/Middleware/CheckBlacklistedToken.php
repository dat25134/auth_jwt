<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\TokenBlacklistService;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckBlacklistedToken
{
    protected $blacklistService;

    public function __construct(TokenBlacklistService $blacklistService)
    {
        $this->blacklistService = $blacklistService;
    }

    public function handle($request, Closure $next)
    {
        try {
            $token = JWTAuth::getToken();
            if ($token && $this->blacklistService->isBlacklisted($token)) {
                return response()->json(['error' => 'Token has been blacklisted'], 401);
            }
            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
} 