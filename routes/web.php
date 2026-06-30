<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\MatchupController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\TournamentParticipantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Games
    Route::resource('games', GameController::class);

    // Teams
    Route::resource('teams', TeamController::class);

    // Tournaments
    Route::resource('tournaments', TournamentController::class);

    // Matchups
    Route::resource('matchups', MatchupController::class)->except(['edit']);

    // Results
    Route::resource('results', ResultController::class)->except(['destroy']);

    Route::resource('tournaments_participants', TournamentParticipantController::class);

});

require __DIR__.'/auth.php';
