<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Models\User;
use App\Models\City;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class CharacterController extends Controller
{
    public function viewMainCharScreen(): View {

        $user = Auth::user();
        $userId = $user->id;
        $characters = User::find($userId)->characters;
        $hasAliveChar = User::find($userId)->characters()->where('status', '0')->count() == 0 ? false : true;

        return view('character', [
            'characters' => $characters,
            'hasAliveChar' => $hasAliveChar
        ]);
    }

    public function createCharacterScreen(): View {

        $user = Auth::user();
        $userId = $user->id;
        $hasAliveChar = User::find($userId)->characters()->where('status', '0')->count() == 0 ? false : true;

        $cities = City::all();

        return view('dashboard.character.character-create', [
            'hasAliveChar' => $hasAliveChar,
            'cities' => $cities
        ]);
    }

    public function createCharacter(Request $request): RedirectResponse {

        $user = Auth::user();
        $userId = $user->id;

        //Validate the name they chose
        $request->validate([
            'name' => ['required', 'string', 'max:30', 'unique:'.Character::class],
        ]);

        //Calculate their character's multipliers based on question choices
        $attackMultiplier = 1;
        $defenseMultiplier = 1;
        $intellectMultiplier = 1;
        $stealthMultiplier = 1;

        switch($request->characterQuestions1) {
            case 'shoot':
                $attackMultiplier += .08;
                $intellectMultiplier -= .04;
                break;
            case 'int':
                $intellectMultiplier += .1;
                $defenseMultiplier -= .04;
                break;
            case 'stealth':
                $stealthMultiplier += .06;
                $attackMultiplier -= .02;
                break;
            case 'def':
                $defenseMultiplier += .09;
                $stealthMultiplier -= .04;
                break;
        }
        
        switch($request->characterQuestions2) {
            case 'shoot':
                $attackMultiplier += .08;
                $intellectMultiplier -= .04;
                break;
            case 'int':
                $intellectMultiplier += .1;
                $defenseMultiplier -= .04;
                break;
            case 'stealth':
                $stealthMultiplier += .06;
                $attackMultiplier -= .02;
                break;
            case 'def':
                $defenseMultiplier += .09;
                $stealthMultiplier -= .04;
                break;
        }

        switch($request->characterQuestions3) {
            case 'shoot':
                $attackMultiplier += .08;
                $intellectMultiplier -= .04;
                break;
            case 'int':
                $intellectMultiplier += .1;
                $defenseMultiplier -= .04;
                break;
            case 'stealth':
                $stealthMultiplier += .06;
                $attackMultiplier -= .02;
                break;
            case 'def':
                $defenseMultiplier += .09;
                $stealthMultiplier -= .04;
                break;
        }

        //Create the character
        $character = Character::create([
            'name' => $request->name,
            'user_id' => $userId,
            'city' => $request->characterLocation,
            'sex' => $request->characterSex,
            'attackMultiplier' => $attackMultiplier,
            'defenseMultiplier' => $defenseMultiplier,
            'stealthMultiplier' => $stealthMultiplier,
            'intellectMultiplier' => $intellectMultiplier
        ]);

        //Redirect user to characters page
        return redirect(RouteServiceProvider::HOME)->with('status', 'character-created');
    }
}
