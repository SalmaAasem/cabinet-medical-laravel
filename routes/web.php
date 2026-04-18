<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Models\User;
use App\Models\Patient;
use App\Models\RendezVous;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function() {
    $user = Auth::user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'medecin') {
        return redirect()->route('medecin.rendez-vous');
    } elseif ($user->role === 'secretaire') {
        return redirect()->route('secretaire.dashboard');
    }

    return redirect()->route('login');
})->middleware(['auth'])->name('dashboard');

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

 
// ─── MODULE ADMINISTRATION (protégé auth + rôle admin) ───────────────────────
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
 
    // Tableau de bord admin avec statistiques et graphiques
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
 
    // Gestion des utilisateurs
    Route::get('/users',              [AdminController::class, 'users'])->name('users');
    Route::get('/users/create',       [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users',             [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit',  [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}',       [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}',    [AdminController::class, 'destroyUser'])->name('users.destroy');
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