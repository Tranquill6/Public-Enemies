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

        //we need to see if their rank allows them to do this crime
        if($crimeSearch['required_rank_value'] > $aliveChar->rank()->get()[0]->rank_value) {
            return Redirect::route('play.crimes')->with(['status' => 'crime-failed', 'message' => 'You are not allowed to do this crime!']);
        }

        //check if crime timer is up
        $timerSearch = $aliveChar->timers()->firstWhere('type', 'crime');
        if($timerSearch != null) {
            return Redirect::route('play.crimes')->with(['status' => 'crime-failed', 'message' => 'You can only commit one crime every minute!']);
        }

        //determine if crime succeeds or not -- TODO: Add chance of going to jail upon failure
        $chanceOfFailure = rand(10,15);
        $successRoll = rand(1,100);
        //crime failed, add timer too
        if($successRoll <= $chanceOfFailure) {
            $this->addCrimeTimer($aliveChar);
            return Redirect::route('play.crimes')->with(['status' => 'crime-failed', 'message' => 'You failed to commit the crime!']);
        }

        //calculate the stat/exp increases and add them to user's alive character
        $charAttackMultiplier = $aliveChar->attackMultiplier;
        $charDefenseMultiplier = $aliveChar->defenseMultiplier;
        $charIntellectMultiplier = $aliveChar->intellectMultiplier;
        $charStealthtMultiplier = $aliveChar->stealthMultiplier;
        $charEnduranceMultiplier = $aliveChar->enduranceMultiplier;

        $aliveChar->attack = $aliveChar->attack + ($crimeSearch['gives_attack'] * $charAttackMultiplier);
        $aliveChar->defense = $aliveChar->defense + ($crimeSearch['gives_defense'] * $charDefenseMultiplier);
        $aliveChar->intellect = $aliveChar->intellect + ($crimeSearch['gives_intellect'] * $charIntellectMultiplier);
        $aliveChar->stealth = $aliveChar->stealth + ($crimeSearch['gives_stealth'] * $charStealthtMultiplier);
        $aliveChar->endurance = $aliveChar->endurance + ($crimeSearch['gives_endurance'] * $charEnduranceMultiplier);
        $aliveChar->exp = $aliveChar->exp + $crimeSearch['gives_exp'];

        //calculate money gain
        $moneyRoll = rand($crimeSearch['lower_money_range'], $crimeSearch['upper_money_range']);
        $aliveChar->money = $aliveChar->money + $moneyRoll;
        $aliveChar->save();

        //setup success message for crime
        $message = $crimeSearch['success_message'] . " $$moneyRoll!";

        //crime is successful, so add crime timer
        $this->addCrimeTimer($aliveChar);
        return Redirect::route('play.crimes')->with(['status' => 'crime-success', 'message' => $message]);
    }

    public function addCrimeTimer($character) {
        $dateTime = now('America/Chicago');
        $dateTime = $dateTime->addMinute();
        Timer::create([
            'character_id' => $character->id,
            'type' => 'crime',
            'expires' => $dateTime
        ]);
    }
}
