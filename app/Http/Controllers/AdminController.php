<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\RendezVous;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // =========================================================
    //  TABLEAU DE BORD
    // =========================================================

    public function dashboard()
    {
        // --- Cartes statistiques principales ---
        $stats = [
            'total_users'      => User::count(),
            'total_patients'   => Patient::count(),
            'total_medecins'   => Medecin::count(),
            'total_rdv'        => RendezVous::count(),
            'rdv_en_attente'   => RendezVous::where('statut', 'En attente')->count(),
            'rdv_confirmes'    => RendezVous::where('statut', 'Confirmé')->count(),
            'rdv_annules'      => RendezVous::where('statut', 'Annulé')->count(),
        ];

        // --- Nouveaux utilisateurs cette semaine ---
        $nouveauxUtilisateurs = User::where('created_at', '>=', now()->startOfWeek())->count();

        // --- RDV par mois (6 derniers mois) pour le graphique linéaire ---
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

        // --- Consultations par mois (6 derniers mois) ---
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

        // --- Répartition des RDV par statut (doughnut) ---
        $rdvStatuts = RendezVous::select('statut', DB::raw('count(*) as total'))
                                ->groupBy('statut')
                                ->pluck('total', 'statut')
                                ->toArray();

        // --- Répartition des utilisateurs par rôle (bar chart) ---
        $usersParRole = User::select('role', DB::raw('count(*) as total'))
                            ->groupBy('role')
                            ->pluck('total', 'role')
                            ->toArray();

        // --- Top 5 médecins (par nombre de RDV) ---
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

    // =========================================================
    //  GESTION DES UTILISATEURS
    // =========================================================

    /**
     * Liste paginée des utilisateurs avec recherche.
     */
    public function users(Request $request)
    {
        $query = User::query();

        // Recherche par nom ou email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtre par rôle
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users', compact('users'));
    }

    /**
     * Formulaire de création d'un utilisateur.
     */
    public function createUser()
    {
        return view('admin.users-create');
    }

    /**
     * Enregistrer un nouvel utilisateur.
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role'     => ['required', Rule::in(['admin', 'medecin', 'secretaire', 'patient'])],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.users')
                         ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Formulaire de modification d'un utilisateur.
     */
    public function editUser(User $user)
    {
        return view('admin.users-edit', compact('user'));
    }

    /**
     * Mettre à jour un utilisateur.
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role'  => ['required', Rule::in(['admin', 'medecin', 'secretaire', 'patient'])],
            // Le mot de passe est optionnel lors de la modification
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        // Mettre à jour le mot de passe uniquement s'il est fourni
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users')
                         ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Supprimer un utilisateur.
     */
    public function destroyUser(User $user)
    {
        // Empêcher la suppression de son propre compte
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')
                             ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('admin.users')
                         ->with('success', 'Utilisateur supprimé avec succès.');
    }
}