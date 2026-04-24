<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\GestionRdvController;
use App\Http\Controllers\PlanningController;

Route::get('/', function () {
    $medecins = App\Models\Medecin::with('user')->get();
    return view('welcome', compact('medecins'));
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'medecin':
            return redirect()->route('medecin.rendez-vous');
        case 'secretaire':
            return redirect()->route('secretaire.dashboard');
        case 'patient':
            return redirect()->route('rendez-vous.index');
        default:
            return redirect('/');
    }
})
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/patients/search', [PatientController::class, 'index'])->name('patients.search');
    Route::get('/patients/{id}/historique', [PatientController::class, 'historique'])->name('patients.historique');
    Route::resource('patients', PatientController::class);
    Route::get('/mon-historique', [PatientController::class, 'myHistory'])->name('patient.my_history');

    Route::get('/prendre-rendez-vous', [RendezVousController::class, 'create'])->name('rendez-vous.create');
    Route::post('/prendre-rendez-vous', [RendezVousController::class, 'store'])->name('rendez-vous.store');
    Route::get('/mes-rendez-vous', [RendezVousController::class, 'index'])->name('rendez-vous.index');
    Route::delete('/rendez-vous/{id}', [RendezVousController::class, 'destroy'])->name('rendez-vous.destroy');

    Route::prefix('medecin')
        ->name('medecin.')
        ->group(function () {
            Route::get('/rendez-vous', [ConsultationController::class, 'index'])->name('rendez-vous');

            Route::get('/patients', [MedecinController::class, 'listPatients'])->name('patients.index');

            Route::get('/consultation/create/{rendezVous}', [ConsultationController::class, 'create'])->name('consultation.create');
            Route::post('/consultation/store', [ConsultationController::class, 'store'])->name('consultation.store');
            Route::get('/medecin/planning', [PlanningController::class, 'index'])->name('planning.index');
            Route::post('/medecin/planning', [PlanningController::class, 'store'])->name('planning.store'); 
            Route::get('/consultation/pdf/{id}', [MedecinController::class, 'downloadPDF'])->name('consultation.pdf');
            Route::get('/consultation/show/{id}', [MedecinController::class, 'showConsultation'])->name('consultation.show');
            Route::get('/patient/{id}/history', [MedecinController::class, 'showHistory'])->name('patient.history');
        });

    Route::get('/api/available-slots', [PlanningController::class, 'getAvailableSlots']);

    Route::get('/secretaire/dashboard', [GestionRdvController::class, 'index'])->name('secretaire.dashboard');
    Route::get('/gestion-rdv', [GestionRdvController::class, 'index'])->name('gestion-rdv.index');
    Route::put('/gestion-rdv/{id}', [GestionRdvController::class, 'update'])->name('gestion-rdv.update');
    Route::delete('/gestion-rdv/{id}', [GestionRdvController::class, 'destroy'])->name('gestion-rdv.destroy');
});

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::resource('users', UserController::class)->except(['index']);
    });

require __DIR__ . '/auth.php';
