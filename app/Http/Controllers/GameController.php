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
use App\Models\City;
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

    public function travelPage(Request $request) {
        //Fetch data from characterData middleware
        $data = $request->get('middlewareData');

        //Get current user
        $user = Auth::user();

        //Fetch all of the crimes a player can do
        if($user->can('access-admin-cities')) {
            $cities = City::all();
        } else {
            $cities = City::where('admin_city', '0')->get();
        }

        //Render the page
        return view('game.travel', [
            'characterData' => $data,
            'cities' => $cities
        ]);
    }

    public function travelCharacter(Request $request) {
        $cityId = $request->travelSpots;
        $user = Auth::user();
        $userId = $user->id;
        $aliveChar = User::find($userId)->characters()->where('status', '0')->get()[0];

        //Make sure they chose a city
        if($cityId == null) {
            return Redirect::route('play.travel')->with(['status' => 'travel-failed', 'message' => 'You must choose somewhere to fly!']);
        }

        //Make sure they chose a city that exists
        $citySearch = City::find($cityId);
        if($citySearch == null) {
            return Redirect::route('play.travel')->with(['status' => 'travel-failed', 'message' => 'That city does not exist!']);
        }

        //Make sure they chose a city that they have permissions for
        if($citySearch['admin_city'] == '1' && !$user->can('access-admin-cities')) {
            return Redirect::route('play.travel')->with(['status' => 'travel-failed', 'message' => 'You do not have permissions for that city!']);
        }

        //Make sure they aren't flying to their same city
        if($citySearch['name'] == $aliveChar->location) {
            return Redirect::route('play.travel')->with(['status' => 'travel-failed', 'message' => 'You cannot fly to a city you are already in!']);
        }

        //Make sure the city has at least $100 to fly
        if($aliveChar->money < 100) {
            return Redirect::route('play.travel')->with(['status' => 'travel-failed', 'message' => 'You do not have enough money to fly!']);
        }

        //Make sure user has their flying timer up
        $timerSearch = $aliveChar->timers()->firstWhere('type', 'travel');
        if($timerSearch != null) {
            return Redirect::route('play.travel')->with(['status' => 'travel-failed', 'message' => 'You can only fly once every hour!']);
        }

        //If everything checks out, travel the user
        $aliveChar->money = $aliveChar->money - 100;
        $aliveChar->city = $citySearch['name'];
        $aliveChar->save();
        $this->addTravelTimer($aliveChar);
        return Redirect::route('play.travel')->with(['status' => 'travel-success', 'message' => 'You have successfully flown to '. $citySearch['name'] . '!']);
    }

    public function profilePage(Request $request, string $id) {
        //Fetch data from characterData middleware
        $data = $request->get('middlewareData');

        //Fetch data for the profile
        $fetchedCharacterData = Character::find($id);

        //Render the page
        return view('game.profile', [
            'characterData' => $data,
            'profileData' => $fetchedCharacterData
        ]);
    }

    //HELPERS
    public function addCrimeTimer($character) {
        $dateTime = now('America/Chicago');
        $dateTime = $dateTime->addMinute();
        Timer::create([
            'character_id' => $character->id,
            'type' => 'crime',
            'expires' => $dateTime
        ]);
    }

    public function addTravelTimer($character) {
        $dateTime = now('America/Chicago');
        $dateTime = $dateTime->addHour();
        Timer::create([
            'character_id' => $character->id,
            'type' => 'travel',
            'expires' => $dateTime
        ]);
    }

}
