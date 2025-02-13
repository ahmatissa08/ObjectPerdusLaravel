<?php

use App\Models\Item;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
     // Récupère les 5 objets les plus récents
     $recentItems = Item::orderBy('created_at', 'desc')->take(5)->get();
     return view('welcome', compact('recentItems'));
});

// Authentification (assurez-vous de n'appeler Auth::routes() qu'une seule fois)
Auth::routes();

// Routes publiques pour visualiser la liste
Route::get('/items', [ItemController::class, 'index'])->name('items.index');

// Routes protégées par authentification pour ajouter des objets
Route::middleware(['auth'])->group(function () {
    Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
});

// Route dynamique pour afficher le détail d'un objet
Route::get('/items/{id}', [ItemController::class, 'show'])->name('items.show');

// Route d'accueil par défaut après connexion
Route::get('/home', [HomeController::class, 'index'])->name('home');
