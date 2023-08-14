<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Character;
use App\Models\User;
use App\Models\Crime;
use App\Models\Timer;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class GameController extends Controller
{
    public function homepage(Request $request): View {

        //Fetch data from characterData middleware
        $data = $request->get('middlewareData');

        //Render the page
        return view('game.play', [
            'characterData' => $data
        ]);
    }

    public function removeTimer(Request $request) {
        $timerIds = $request->get('timerIds');
        $result = Timer::whereIn('id', $timerIds)->delete();
        if(!$result) {
            return array('status' => false);
        }
        return array('status' => true);
    }

    public function crimesPage(Request $request): View {

        //Fetch data from characterData middleware
        $data = $request->get('middlewareData');

        //Fetch all of the crimes a player can do
        $crimes = Crime::all();

        //Render the page
        return view('game.crimes', [
            'characterData' => $data,
            'crimes' => $crimes
        ]);
    }

    public function commitCrime(Request $request): RedirectResponse {
        $user = Auth::user();
        $userId = $user->id;
        $aliveChar = User::find($userId)->characters()->where('status', '0')->get()[0];
        $chosenCrimeId = $request->chosenCrimeId;

        //if chosen crime id is undefined then user didn't choose crime
        if($chosenCrimeId == null) {
            return Redirect::route('play.crimes')->with(['status' => 'crime-failed', 'message' => 'You have to choose a crime to commit one!']);
        }

        //we need to see if the crime chosen is valid, aka the user didn't alter the html
        $crimeSearch = Crime::find($chosenCrimeId);
         //crime not found, throw error
        if($crimeSearch == null) {
            return Redirect::route('play.crimes')->with(['status' => 'crime-failed', 'message' => 'The crime you selected does not exist!']);
        }

        //Check if crime timer is up
        $timerSearch = $aliveChar->timers()->firstWhere('type', 'crime');
        if($timerSearch != null) {
            return Redirect::route('play.crimes')->with(['status' => 'crime-failed', 'message' => 'You can only commit one crime every minute!']);
        }

        //calculate the stat/exp increases and add them to user's alive character -- TODO

        //crime is successful, so add crime timer
        $dateTime = now();
        $dateTime = $dateTime->addMinutes(1);
        Timer::create([
            'character_id' => $aliveChar->id,
            'type' => 'crime',
            'expires' => $dateTime
        ]);
        return Redirect::route('play.crimes')->with(['status' => 'crime-success', 'message' => 'You have successfully beaten up an old bitch for her purse for $5!']);
    }
}
