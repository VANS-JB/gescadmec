<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\BesoinController;
use App\Http\Controllers\AuthentificateController;



Route::get('/', function () {
    return view('utilisateurs.register');
});

// Routes d'authentification
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthentificateController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthentificateController::class, 'register']);
    Route::get('/login', [AuthentificateController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthentificateController::class, 'login']);
});

// Routes protégées
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthentificateController::class, 'logout'])->name('logout');
    Route::get('/dashboard', function () {
        return view('utilisateurs.dashboard');
    })->name('utilisateurs.dashboard');
});

// Routes pour les étudiants
Route::resource('etudiants', EtudiantController::class);

// Routes pour les inscriptions
Route::resource('inscriptions', InscriptionController::class);

// Routes pour les paiements
Route::resource('paiements', PaiementController::class);
Route::get('statistiques', [PaiementController::class, 'statistiques'])->name('paiements.statistiques');

// Routes pour les besoins
Route::resource('besoins', BesoinController::class);
Route::patch('besoins/{besoin}/statut', [BesoinController::class, 'updateStatut'])->name('besoins.updateStatut');

// Route pour les reçus
Route::get('/recu/{paiement}', function ($paiementId) {
    $paiement = \App\Models\Paiement::with(['inscription.etudiant', 'inscription.niveau'])->findOrFail($paiementId);
    return view('recu', compact('paiement'));
})->name('recu.show');