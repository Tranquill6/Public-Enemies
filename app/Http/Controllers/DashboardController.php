<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Keys;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function owner(): View {
        return view('dashboard.owner-dashboard');
    }

    public function admin(): View {
        return view('dashboard.admin-dashboard');
    }

    public function alphakeys(): View {
        return view('dashboard.admin.generate-alpha-keys', [
            'keys' => Keys::where('used', '=', 0)->get()
        ]);
    }

    public function createalphakey(): RedirectResponse {
        $newKey = new Keys;
        $newKey->save();
        return Redirect::route('dashboard.admin.generateAlphaKeys')->with('status', 'key-generated');
    }
}
