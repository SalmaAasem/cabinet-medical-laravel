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
    //  TABLEAU DE BORD (ONLY)
    // =========================================================

    public function dashboard()
    {
        //  Statistiques principales
        $stats = [
            'total_users'      => User::count(),
            'total_patients'   => Patient::count(),
            'total_medecins'   => Medecin::count(),
            'total_rdv'        => RendezVous::count(),
            'rdv_en_attente'   => RendezVous::where('statut', 'En attente')->count(),
            'rdv_confirmes'    => RendezVous::where('statut', 'Confirmé')->count(),
            'rdv_annules'      => RendezVous::where('statut', 'Annulé')->count(),
        ];

        //  Nouveaux utilisateurs cette semaine
        $nouveauxUtilisateurs = User::where('created_at', '>=', now()->startOfWeek())->count();

        //  RDV par mois
        $rdvParMois = [];
        for ($i = 5; $i >= 0; $i--) {
            $date  = now()->subMonths($i);
            $total = RendezVous::whereYear('created_at', $date->year)
                               ->whereMonth('created_at', $date->month)
                               ->count();

            $rdvParMois[] = [
                'mois'  => $date->format('M Y'),
                'total' => $total,
            ];
        }

        //  Consultations par mois
        $consultationsParMois = [];
        for ($i = 5; $i >= 0; $i--) {
            $date  = now()->subMonths($i);
            $total = Consultation::whereYear('created_at', $date->year)
                                 ->whereMonth('created_at', $date->month)
                                 ->count();

            $consultationsParMois[] = [
                'mois'  => $date->format('M Y'),
                'total' => $total,
            ];
        }

        // RDV par statut
        $rdvStatuts = RendezVous::select('statut', DB::raw('count(*) as total'))
                                ->groupBy('statut')
                                ->pluck('total', 'statut')
                                ->toArray();

        //  Users par rôle
        $usersParRole = User::select('role', DB::raw('count(*) as total'))
                            ->groupBy('role')
                            ->pluck('total', 'role')
                            ->toArray();

        //  Top médecins
        $topMedecins = Medecin::withCount('rendezVous')
                              ->orderByDesc('rendez_vous_count')
                              ->take(5)
                              ->get();

        return view('admin.dashboard', compact(
            'stats',
            'nouveauxUtilisateurs',
            'rdvParMois',
            'consultationsParMois',
            'rdvStatuts',
            'usersParRole',
            'topMedecins'
        ));
    }
}