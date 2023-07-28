<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BannedController extends Controller
{
    public function view(): View {
        $user = Auth::user();
        $banDate = $user->ban_expires_at;
        return view('banned', [
            'banDate' => $banDate
        ]);
    }
}
