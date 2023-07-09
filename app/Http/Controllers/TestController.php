<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\test;

class TestController extends Controller 
{

    public function index(): View {
        $test = test::where('id', 1)
                    ->get();

        return view('home', ['test' => $test]);
    }

}