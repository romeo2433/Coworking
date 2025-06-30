<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ImportReservationController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\StatistiqueController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/** Authentification utilisateur */
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/** Tableau de bord utilisateur */
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ReservationController::class, 'create'])->name('dashboard');

    /** Réservations */
    Route::get('/reservation/create', [ReservationController::class, 'showReservationForm'])->name('reservation.create');
    Route::get('/reservation/{id_espace}/{date}', [ReservationController::class, 'showReservationForm'])->name('reservation.form');
    Route::post('/reservation/store', [ReservationController::class, 'store'])->name('reservation.store');
    Route::get('/reservations', [ReservationController::class, 'showReservations'])->name('user.reservations');

    /** Paiement */
    Route::get('/paiement/{id}', [ReservationController::class, 'afficherPagePaiement'])->name('reservation.paiement');
    Route::post('/reservation/valider-paiement', [ReservationController::class, 'validerPaiement'])->name('reservation.validerPaiement');
});

/** Authentification administrateur */
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    /** Routes protégées admin */
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/reservations/valider/{id_reservation}', [AdminController::class, 'validerReservation'])->name('admin.reservations.valider');
    });
});

/** Importation d'espaces */
Route::get('/import-espaces', [ImportController::class, 'showForm'])->name('import.form');
Route::post('/import', [ImportController::class, 'import'])->name('import');

/** Importation de réservations */
Route::get('/import-reservations', function () {
    return view('import-reservations');
})->name('import.reservations.form');
Route::post('/import-reservations', [ImportReservationController::class, 'importCSV'])->name('import.reservations');

/** Importation de paiements */
Route::get('/paiements/import', [PaiementController::class, 'showImportForm'])->name('paiements.import');
Route::post('/paiements/import', [PaiementController::class, 'import'])->name('paiements.import.process');



/**Statistique  */
Route::get('/admin/statistiques', [AdminController::class, 'statistiques'])->name('admin.stats');
Route::get('/admin/Affaire', [AdminController::class, 'statistiquesAffaireJour'])->name('admin.Affaire');
