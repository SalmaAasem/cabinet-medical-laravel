<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RendezVousController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/ordonnance/{id}/pdf', [App\Http\Controllers\OrdonnanceController::class, 'pdf'])->name('ordonnance.pdf');

Route::middleware(['auth'])->group(function () {
    Route::get('/prendre-rendez-vous', [RendezVousController::class, 'create'])->name('rendez-vous.create');
    Route::post('/rendez-vous', [RendezVousController::class, 'store'])->name('rendez-vous.store');
    Route::get('/mes-rendez-vous', [RendezVousController::class, 'index'])->name('rendez-vous.index');
    Route::delete('/rendez-vous/{id}', [RendezVousController::class, 'destroy'])->name('rendez-vous.destroy'); // ← AJOUTER CETTE LIGNE
});

// Routes pour les médecins
Route::middleware(['auth'])->group(function () {
    Route::get('/medecin/rendez-vous', [App\Http\Controllers\ConsultationController::class, 'index'])->name('medecin.rendez-vous');
    Route::get('/medecin/consultation/{id}', [App\Http\Controllers\ConsultationController::class, 'create'])->name('medecin.consultation.create');
    Route::post('/medecin/consultation', [App\Http\Controllers\ConsultationController::class, 'store'])->name('medecin.consultation.store');
});

// Routes pour la gestion des patients
Route::middleware(['auth'])->group(function () {
    Route::get('/patients/create', [App\Http\Controllers\PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [App\Http\Controllers\PatientController::class, 'store'])->name('patients.store');
Route::get('/patients/search', [App\Http\Controllers\PatientController::class, 'search'])->name('patients.search');
Route::get('/patients', [App\Http\Controllers\PatientController::class, 'index'])->name('patients.index');
});

// Routes pour la gestion des RDV (secrétaire/admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/gestion-rdv', [App\Http\Controllers\GestionRdvController::class, 'index'])->name('gestion-rdv.index');
    Route::put('/gestion-rdv/{id}', [App\Http\Controllers\GestionRdvController::class, 'update'])->name('gestion-rdv.update');
    Route::delete('/gestion-rdv/{id}', [App\Http\Controllers\GestionRdvController::class, 'destroy'])->name('gestion-rdv.destroy');
});

require __DIR__.'/auth.php';