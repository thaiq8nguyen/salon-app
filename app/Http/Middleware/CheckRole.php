<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::user();
        $userRole = $user->roles()->first()->name;

        if ($userRole != $role) {
            return response()->json(['success' => false, 'message' => 'unauthorized']);
        }
        return $next($request);
    }
}
