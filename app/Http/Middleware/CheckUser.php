<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = User::where('organization_id', auth()->user()->organization_id)
                ->findOrFail($request->route()->parameter('user'));

            $request->attributes->add(['user' => $user]);

            return $next($request);
        } catch (ModelNotFoundException) {
            abort(401);
        }
    }
}
