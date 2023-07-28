<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Keys;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
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
    
    public function ban(): View {
        return view('dashboard.admin.ban-user', [
            'users' => User::with('roles')->get()
        ]);
    }

    public function banUser(Request $request) {
        $banData = $request->all();
        $fetchedUser = User::find($banData['userId']);
        $fetchedUser->assignRole('Banned');
        $fetchedUser->ban_expires_at = $banData['date'];
        $fetchedUser->save();
        return array('status' => 'user-banned');
    }

    public function unbanUser(Request $request) {
        $banData = $request->all();
        $fetchedUser = User::find($banData['userId']);
        $fetchedUser->removeRole('Banned');
        $fetchedUser->ban_expires_at = null;
        $fetchedUser->save();
        return array('status' => 'user-unbanned');
    }
}
