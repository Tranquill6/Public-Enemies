<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BannedController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GameController;
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

//logged in user routes
Route::middleware('auth')->group(function () {
    Route::get('/banned', [BannedController::class, 'view'])->name('banned');
});

Route::middleware(['auth', 'bancheck'])->group(function () {
    //profile page
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //character page
    Route::get('/character', [CharacterController::class, 'viewMainCharScreen'])->name('character.main');
});

Route::middleware(['auth', 'bancheck', 'createCharacterCheck'])->group(function () {
    Route::get('/character/create', [CharacterController::class, 'createCharacterScreen'])->name('character.create');
    Route::post('/character/createCharacter', [CharacterController::class, 'createCharacter'])->name('character.createCharacter');
});

//Game routes (need to be logged in + have alive char)
Route::middleware(['auth', 'bancheck', 'characterCheck', 'characterData'])->group(function () {
    Route::get('/play', [GameController::class, 'homepage'])->name('play.home');
});

//Game Ajax Routes
Route::middleware(['auth', 'bancheck', 'characterCheck'])->group(function () {
    Route::post('/removetimer', [GameController::class, 'removeTimer'])->name('play.removeTimer');
});

//Admin+ only routes
Route::middleware(['can:access-admin-dashboard', 'auth', 'bancheck'])->group(function() {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
});

Route::middleware(['can:ban-user', 'auth', 'bancheck'])->group(function() {
    Route::get('/dashboard/admin/ban', [DashboardController::class, 'ban'])->name('dashboard.admin.ban');
    Route::post('/dashboard/admin/banuser', [DashboardController::class, 'banUser'])->name('dashboard.admin.banUser');
    Route::post('/dashboard/admin/unbanuser', [DashboardController::class, 'unbanUser'])->name('dashboard.admin.unbanUser');
});

Route::middleware(['can:generate-alpha-keys', 'auth', 'bancheck'])->group(function() {
    Route::get('/dashboard/admin/generatealphakeys', [DashboardController::class, 'alphakeys'])->name('dashboard.admin.generateAlphaKeys');
    Route::post('/dashboard/admin/generatealphakeyspost', [DashboardController::class, 'createalphakey'])->name('dashboard.admin.generateAlphaKeys.create');
});

//Owner only routes
Route::middleware(['can:access-owner-dashboard', 'auth', 'bancheck'])->group(function() {
    Route::get('/dashboard/owner', [DashboardController::class, 'owner'])->name('dashboard.owner');
});

require __DIR__.'/auth.php';
