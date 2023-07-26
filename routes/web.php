<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Admin+ only routes
Route::middleware('can:access-admin-dashboard')->group(function() {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
});

Route::middleware('can:generate-alpha-keys')->group(function() {
    Route::get('/dashboard/admin/generatealphakeys', [DashboardController::class, 'alphakeys'])->name('dashboard.admin.generateAlphaKeys');
    Route::post('/dashboard/admin/generatealphakeyspost', [DashboardController::class, 'createalphakey'])->name('dashboard.admin.generateAlphaKeys.create');
});

//Owner only routes
Route::middleware('can:access-owner-dashboard')->group(function() {
    Route::get('/dashboard/owner', [DashboardController::class, 'owner'])->name('dashboard.owner');
});

require __DIR__.'/auth.php';
