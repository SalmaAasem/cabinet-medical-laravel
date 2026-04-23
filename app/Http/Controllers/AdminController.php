<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\RendezVous;
use App\Models\Consultation;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // =========================================================

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_patients' => Patient::count(),
            'total_medecins' => Medecin::count(),
            'total_rdv' => RendezVous::count(),
            'rdv_en_attente' => RendezVous::where('statut', 'en_attente')->count(),
            'rdv_confirmes' => RendezVous::where('statut', 'Confirme')->count(),
            'rdv_termines' => RendezVous::where('statut', 'termine')->count(),
            'rdv_annules' => RendezVous::where('statut', 'Annule')->count(),
        ];

        $nouveauxUtilisateurs = User::where('created_at', '>=', now()->startOfWeek())->count();

        $rdvParMois = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $total = RendezVous::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->count();

            $rdvParMois[] = [
                'mois' => $date->format('M Y'),
                'total' => $total,
            ];
        }

        $consultationsParMois = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $total = Consultation::whereYear('created_at', $date->year)->whereMonth('created_at', $date->month)->count();

            $consultationsParMois[] = [
                'mois' => $date->format('M Y'),
                'total' => $total,
            ];
        }

        $rdvStatuts = RendezVous::select('statut', DB::raw('count(*) as total'))->groupBy('statut')->pluck('total', 'statut')->toArray();

        $usersParRole = User::select('role', DB::raw('count(*) as total'))->groupBy('role')->pluck('total', 'role')->toArray();

        $topMedecins = Medecin::withCount('rendezVous')->orderByDesc('rendez_vous_count')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'nouveauxUtilisateurs', 'rdvParMois', 'consultationsParMois', 'rdvStatuts', 'usersParRole', 'topMedecins'));
    }
}
