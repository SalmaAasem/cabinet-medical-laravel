<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use App\Models\Patient;
use App\Models\RendezVous;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::get('/ordonnance/{id}/pdf', [App\Http\Controllers\OrdonnanceController::class, 'pdf'])->name('ordonnance.pdf');

Route::post('/rdv/store', function (Request $request) {
    RendezVous::create([
        'patient_id' => $request->patient_id,
        'specialite' => $request->specialite,
        'date_rdv' => $request->date_rdv,
        'statut' => 'En attente'
    ]);
    return back()->with('success', 'Rendez-vous ajouté avec succès !');
})->name('rdv.store');

// Route pour l'interface Secrétaire
Route::get('/secretaire/dashboard', function () {
    $total_patients = Patient::count();
    $total_rdv = RendezVous::count();
    $rdv_today = RendezVous::whereDate('created_at', today())->count();

    $recent_rdvs = RendezVous::with('patient')->latest()->take(5)->get();

    return view('secretaire.dashboard', compact('total_patients', 'total_rdv', 'rdv_today', 'recent_rdvs'));
})->name('secretaire.dashboard');

Route::get('/secretaire/patients', function () {
    $patients = Patient::all();
    return view('secretaire.patients', compact('patients'));
})->name('patients.index');

Route::get('/admin/users', function () {
    try {
        $users = User::all();
        return view('admin.users', compact('users'));
    } catch (\Exception $e) {
        return "Erreur : " . $e->getMessage();
    }
})->name('admin.users');

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';