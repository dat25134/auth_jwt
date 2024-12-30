<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class TokenBlacklistService
{
    const BLACKLIST_PREFIX = 'blacklist:';
    const BLACKLIST_TTL = 86400; // 24 hours

    public static function blacklist($token)
    {
        $key = self::BLACKLIST_PREFIX . md5($token);
        Redis::setex($key, self::BLACKLIST_TTL, 'revoked');
    }

    public static function isBlacklisted($token)
    {
        $key = self::BLACKLIST_PREFIX . md5($token);
        return Redis::exists($key);
    }
} 