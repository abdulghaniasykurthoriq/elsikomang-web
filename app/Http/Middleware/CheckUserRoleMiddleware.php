<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRoleMiddleware
{
    
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();
        // dd($user);

        if ($user && in_array($user->role, $roles)) {
            return $next($request);
        }

        abort(403, 'akses Dilarang');
    }
}
