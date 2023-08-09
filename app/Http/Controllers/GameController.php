<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Character;
use App\Models\User;
use Carbon\Carbon;

class GameController extends Controller
{
    public function homepage(): View {

        //TODO: Move this into a middleware that effects every game-related page
        //Fetch player's active character
        $user = Auth::user();
        $userId = $user->id;
        $aliveChar = User::find($userId)->characters()->where('status', '0')->get();

        //Map over collection and edit the player's last active time to now and save
        $aliveChar->map(function($item, $key) {
            $item->lastActive = Carbon::now()->toDateTimeString();
            $item->save();
        });

        //Render the page
        return view('game.play');
    }
}
