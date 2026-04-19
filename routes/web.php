<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrdonnanceController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\GestionRdvController;
use App\Models\User;
use App\Models\Patient;
use App\Models\RendezVous;

Route::get('/', function () {
    return view('welcome');
});

// ── Dashboard avec redirect selon rôle ──
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

Route::middleware(['auth'])->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Patients
    Route::get('/patients/search', [PatientController::class, 'search'])->name('patients.search');
    Route::get('/patients/{id}/historique', [PatientController::class, 'historique'])->name('patients.historique');
    Route::resource('patients', PatientController::class);
    Route::get('/mon-historique', [PatientController::class, 'myHistory'])->name('patient.my_history');

    // Rendez-vous
    Route::get('/prendre-rendez-vous', [RendezVousController::class, 'create'])->name('rendez-vous.create');
    Route::post('/prendre-rendez-vous', [RendezVousController::class, 'store'])->name('rendez-vous.store');
    Route::get('/mes-rendez-vous', [RendezVousController::class, 'index'])->name('rendez-vous.index');
    Route::delete('/rendez-vous/{id}', [RendezVousController::class, 'destroy'])->name('rendez-vous.destroy');

    Route::post('/rdv/store', function (Request $request) {
        RendezVous::create([
            'patient_id' => $request->patient_id,
            'specialite' => $request->specialite,
            'date_rdv'   => $request->date_rdv,
            'statut'     => 'En attente'
        ]);
        return back()->with('success', 'Rendez-vous ajouté avec succès !');
    })->name('rdv.store');

    // Médecin
    Route::get('/medecin/rendez-vous', [ConsultationController::class, 'index'])->name('medecin.rendez-vous');
    Route::get('/medecin/patients', [MedecinController::class, 'listPatients'])->name('medecin.patients.index');
    Route::get('/medecin/patient/{id}/history', [MedecinController::class, 'showHistory'])->name('medecin.patient.history');
    Route::get('/medecin/consultation/{id}', [ConsultationController::class, 'create'])->name('medecin.consultation.create');
    Route::post('/medecin/consultation', [ConsultationController::class, 'store'])->name('medecin.consultation.store');
    Route::get('/ordonnance/{id}/pdf', [OrdonnanceController::class, 'pdf'])->name('ordonnance.pdf');

    // Secrétaire
    Route::get('/secretaire/dashboard', function () {
        $total_patients = Patient::count();
        $total_rdv = RendezVous::count();
        $rdv_today = RendezVous::whereDate('created_at', today())->count();
        $recent_rdvs = RendezVous::with('patient')->latest()->take(5)->get();
        return view('secretaire.dashboard', compact('total_patients', 'total_rdv', 'rdv_today', 'recent_rdvs'));
    })->name('secretaire.dashboard');

    Route::get('/secretaire/patients', [PatientController::class, 'index'])->name('secretaire.patients.index');

    // Gestion RDV
    Route::get('/gestion-rdv', [GestionRdvController::class, 'index'])->name('gestion-rdv.index');
    Route::put('/gestion-rdv/{id}', [GestionRdvController::class, 'update'])->name('gestion-rdv.update');
    Route::delete('/gestion-rdv/{id}', [GestionRdvController::class, 'destroy'])->name('gestion-rdv.destroy');
});

// ── Module Administration ──
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';