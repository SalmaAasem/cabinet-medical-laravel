<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrdonnanceController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\GestionRdvController;
use App\Models\User;
use App\Models\Patient;
use App\Models\RendezVous;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    
    // 1. Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 3. Patients Management 
    Route::get('/patients/search', [PatientController::class, 'search'])->name('patients.search');
    Route::get('/patients/{id}/historique', [PatientController::class, 'historique'])->name('patients.historique');
    Route::resource('patients', PatientController::class);
    Route::get('/secretaire/patients', [PatientController::class, 'index'])->name('secretaire.patients.index');

    // 4. Appointment (Rendez-vous)
    Route::get('/prendre-rendez-vous', [RendezVousController::class, 'create'])->name('rendez-vous.create');
    Route::post('/prendre-rendez-vous', [RendezVousController::class, 'store'])->name('rendez-vous.store');
    Route::get('/mes-rendez-vous', [RendezVousController::class, 'index'])->name('rendez-vous.index');
    Route::delete('/rendez-vous/{id}', [RendezVousController::class, 'destroy'])->name('rendez-vous.destroy');

    // 5. Doctor Interface (Consultations)
    Route::get('/medecin/rendez-vous', [ConsultationController::class, 'index'])->name('medecin.rendez-vous');
    Route::get('/medecin/consultation/{id}', [ConsultationController::class, 'create'])->name('medecin.consultation.create');
    Route::post('/medecin/consultation', [ConsultationController::class, 'store'])->name('medecin.consultation.store');
    Route::get('/ordonnance/{id}/pdf', [OrdonnanceController::class, 'pdf'])->name('ordonnance.pdf');

    // 6. Secretary and Admin Interface
    Route::get('/secretaire/dashboard', function () {
        $total_patients = Patient::count();
        $total_rdv = RendezVous::count();
        $rdv_today = RendezVous::whereDate('created_at', today())->count();
        $recent_rdvs = RendezVous::with('patient')->latest()->take(5)->get();
        return view('secretaire.dashboard', compact('total_patients', 'total_rdv', 'rdv_today', 'recent_rdvs'));
    })->name('secretaire.dashboard');

    // Appointments Management
    Route::get('/gestion-rdv', [GestionRdvController::class, 'index'])->name('gestion-rdv.index');
    Route::put('/gestion-rdv/{id}', [GestionRdvController::class, 'update'])->name('gestion-rdv.update');
    Route::delete('/gestion-rdv/{id}', [GestionRdvController::class, 'destroy'])->name('gestion-rdv.destroy');

    // Users Management (Admin)
    Route::get('/admin/users', function () {
        $users = User::all();
        return view('admin.users', compact('users'));
    })->name('admin.users');
});

require __DIR__.'/auth.php';