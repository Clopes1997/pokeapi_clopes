<?php

use App\Http\Controllers\PokemonController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pokemon', [PokemonController::class, 'index'])->name('pokemon.index');
    Route::get('/pokemon/favorites', [PokemonController::class, 'favorites'])->name('pokemon.favorites');
    Route::get('/pokemon/{id}', [PokemonController::class, 'show'])->name('pokemon.show');
    Route::post('/pokemon/import/{apiId}', [PokemonController::class, 'import'])->name('pokemon.import');
    Route::post('/pokemon/{id}/favorite', [PokemonController::class, 'favorite'])->name('pokemon.favorite');
    Route::delete('/pokemon/{id}/favorite', [PokemonController::class, 'unfavorite'])->name('pokemon.unfavorite');
});

require __DIR__.'/auth.php';
