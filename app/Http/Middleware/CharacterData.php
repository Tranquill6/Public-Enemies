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
//ANY CHANGES HERE MUST BE DONE ON GAMELAYOUT.PHP
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
        $aliveChar = User::find($userId)->characters()->where('status', '0')->get()[0];

        //store values
        $id = $aliveChar->id;
        $description = $aliveChar->description;
        $timers = $aliveChar->timers()->get();
        $location = $aliveChar->city;
        $money = $aliveChar->money;
        $health = $aliveChar->health;
        $rank = $aliveChar->rank()->get()[0]->name;
        $rankValue = $aliveChar->rank()->get()[0]->rank_value;

        //Add any data we need to pass to controller here
        $request->attributes->add(['middlewareData' => [
            'timers' => $timers,
            'location' => $location,
            'health' => $health,
            'money' => $money,
            'rank' => $rank,
            'rankValue' => $rankValue,
            'id' => $id,
            'description' => $description
        ]]);

        return $next($request);
    }
}
