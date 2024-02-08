<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPartOfChannel
{
    /**
     * Checks if the user is part of the channel and therefore can do an action.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->attributes->get('isPartOfChannel')) {
            abort(401);
        }

        return $next($request);
    }
}
