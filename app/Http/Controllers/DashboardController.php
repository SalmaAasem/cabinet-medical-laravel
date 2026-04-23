<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\Consultation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $rdvAujourdhui = RendezVous::count();
        $totalPatients = Patient::count();
        $totalMedecins = Medecin::count();
        $consultationsMois = Consultation::whereMonth('created_at', now()->month)->count();

        return view('dashboard', compact('rdvAujourdhui', 'totalPatients', 'totalMedecins', 'consultationsMois'));
    }
}
