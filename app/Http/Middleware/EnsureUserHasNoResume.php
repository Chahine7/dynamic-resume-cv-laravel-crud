<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PersonalInformation;

class EnsureUserHasNoResume
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (PersonalInformation::where('user_id', $user->id)->exists()) {
            return redirect()->route('index')->with('error', 'You already have a resume. Please edit it instead.');
        }

        return $next($request);
    }
}