<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CharacterCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $userId = $user->id;
        $hasAliveChar = User::find($userId)->characters()->where('status', '0')->count() == 0 ? false : true;

        if(!$hasAliveChar) {
            return back();
        }

        return $next($request);
    }
}
