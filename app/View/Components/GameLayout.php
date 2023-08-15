<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Character;
use Carbon\Carbon;

class GameLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {

        //Fetch player's active character
        $user = Auth::user();
        $userId = $user->id;
        $aliveChar = User::find($userId)->characters()->where('status', '0')->get();

        // Has to be set as global so we can change it in the map method
        global $id;
        global $timers;
        global $location;
        global $money;
        global $health;
        global $rank;
        global $rankValue;

        //Map over collection and edit the player's last active time to now and save
        $aliveChar->map(function($item, $key) {
            $item->lastActive = Carbon::now()->toDateTimeString();
            $item->save();
            //fetch any timers the character has

            // We have to have this too, or else it wont change the variable outside of this
            global $id;
            global $timers;
            global $location;
            global $money;
            global $health;
            global $rank;
            global $rankValue;

            //store values
            $id = $item->id;
            $timers = $item->timers()->get();
            $location = $item->city;
            $money = $item->money;
            $health = $item->health;
            $rank = $item->rank()->get()[0]->name;
            $rankValue = $item->rank()->get()[0]->rank_value;
        });

        //Add any data we need to pass to controller here
        $characterData = array(
            'timers' => $timers,
            'location' => $location,
            'health' => $health,
            'money' => $money,
            'rank' => $rank,
            'rankValue' => $rankValue,
            'id' => $id
        );

        //Fetches users on in the last 15 mintues
        //Didn't know how to do this in Eloquent and this seemed easier
        $lastOnline = \DB::table('characters')->where('lastActive', '>', Carbon::now()->subMinutes(15)->toDateTimeString())->get();

        return view('layouts.game', [
            'characterData' => $characterData,
            'lastOnline' => $lastOnline
        ]);
    }
}
