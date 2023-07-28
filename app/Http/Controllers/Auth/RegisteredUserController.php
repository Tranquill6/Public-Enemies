<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Models\Keys;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Validator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $testKey = new Keys;
        $testKey->save();
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {

        //Add validation to check for white spaces specifically for usernames
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });

        //Validate everything to make sure input is valid
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'without_spaces', 'unique:'.User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'key' => ['required', 'string', Rule::exists('keys')->where(function ($query) {
                return $query->where('key', request()->get('key'))->where('used', 0);
            })],
        ],
        [
            'key' => 'A valid alpha key must be supplied to play',
            'username.without_spaces' => 'Spaces are not allowed in usernames'
        ]);

        //Mark alpha key as used
        $key = Keys::find(request()->get('key'));
        $key->used = 1;
        $key->save();

        //Create user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //Assign user a role
        $user->assignRole('User');

        //Register new user
        event(new Registered($user));

        //Log new user in
        Auth::login($user);

        //Redirect user to homepage
        return redirect(RouteServiceProvider::HOME);
    }
}
