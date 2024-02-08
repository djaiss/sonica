<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPartOfTeam
{
    /**
     * Checks if the user is part of the team and therefore can do an action.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->attributes->get('isPartOfTeam')) {
            abort(401);
        }

        return $next($request);
    }
}
