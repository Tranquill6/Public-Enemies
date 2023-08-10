<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Models\Timer;
use Carbon\Carbon;

//This middleware fetches any data or does any actions we need to do for every game-related page that involves a playing character
class CharacterData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        //Fetch player's active character
        $user = Auth::user();
        $userId = $user->id;
        $aliveChar = User::find($userId)->characters()->where('status', '0')->get();

        // Has to be set as global so we can change it in the map method
        global $timers;
        global $location;
        global $money;
        global $health;

        //Map over collection and edit the player's last active time to now and save
        $aliveChar->map(function($item, $key) {
            $item->lastActive = Carbon::now()->toDateTimeString();
            $item->save();
            //fetch any timers the character has

             // We have to have this too, or else it wont change the variable outside of this
            global $timers;
            global $location;
            global $money;
            global $health;

            //store values
            $timers = $item->timers()->get();
            $location = $item->city;
            $money = $item->money;
            $health = $item->health;
        });

        //Add any data we need to pass to controller here
        $request->attributes->add(['middlewareData' => [
            'timers' => $timers,
            'location' => $location,
            'health' => $health,
            'money' => $money
        ]]);

        return $next($request);
    }
}
