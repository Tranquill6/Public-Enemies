<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Character;
use App\Models\User;
use App\Models\Timer;
use Carbon\Carbon;

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

        //Render the page
        return view('game.crimes', [
            'characterData' => $data
        ]);
    }
}
