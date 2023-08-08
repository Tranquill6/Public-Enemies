<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

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

        return view('dashboard.character.character-create', [
            'hasAliveChar' => $hasAliveChar
        ]);
    }
}
