<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTeam
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (is_string($request->route()->parameter('team'))) {
            $id = (int) $request->route()->parameter('team');
        } else {
            $id = $request->route()->parameter('team')->id;
        }

        try {
            $team = Team::where('organization_id', auth()->user()->organization_id)
                ->with('users')
                ->findOrFail($id);

            $isPartOfTeam = $team->users->contains(auth()->user()->id);

            if (! $team->is_public && ! $isPartOfTeam) {
                abort(401);
            }

            $request->attributes->add(['team' => $team]);
            $request->attributes->add(['isPartOfTeam' => $isPartOfTeam]);

            return $next($request);
        } catch (ModelNotFoundException) {
            abort(401);
        }
    }
}
