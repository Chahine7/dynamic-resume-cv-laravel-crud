<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthorizeResourceAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $requestedUserId = $request->route('id');
        $authUser = $request->user();

        if (!$authUser) {
            abort(403, 'Unauthorized action.');
        }

        if (!$authUser->isAdmin() && $authUser->id != $requestedUserId) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
