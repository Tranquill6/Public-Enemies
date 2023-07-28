<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        //if user is logged in, fetch them and check if they are banned
        //see if their ban is up, then remove banned role and continue
        //else, send them to banned page upon login
        $user = Auth::user();
        if($user->ban_expires_at != null) {
            //check their banned date versus today's date
            $bannedDate = date('Y-m-d', strtotime($user->ban_expires_at->toDateTimeString()));
            $todayDate = date("Y-m-d");
            if($bannedDate > $todayDate) {
                return redirect()->intended(RouteServiceProvider::BANNED);
            }

            //remove anything ban related, since ban expired
            $user->removeRole('Banned');
            $user->ban_expires_at = null;
            $user->save();
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
