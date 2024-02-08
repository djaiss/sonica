<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    public static function get(string $key, array $params, int $ttl, callable $callback): mixed
    {
        // the key is something like team:{team-id}:users
        // so we need to take each param, and replace the {param} with the value
        foreach ($params as $param => $value) {
            $key = str_replace('{' . $param . '}', $value, $key);
        }

        return Cache::remember($key, $ttl, $callback);
    }
}
