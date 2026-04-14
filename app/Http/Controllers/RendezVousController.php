<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\RendezVous;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RendezVousController extends Controller
{
    public function create()
    {
        $medecins = Medecin::with('user')->get();
        return view('rendezvous.create', compact('medecins'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'date_heure' => 'required|date',
        ]);

        // Cas 1 : Utilisateur connecté et a un dossier patient
        if (Auth::check() && Auth::user()->role == 'patient' && Auth::user()->patient) {
            $patient = Auth::user()->patient;
            
            RendezVous::create([
                'patient_id' => $patient->id,
                'medecin_id' => $request->medecin_id,
                'date_heure' => $request->date_heure,
                'motif' => $request->motif,
                'statut' => 'en_attente',
            ]);
            
            return redirect()->route('dashboard')->with('success', 'Rendez-vous réservé avec succès !');
        }
        
        // Cas 2 : Utilisateur non connecté OU pas de dossier patient
        $request->validate([
            'patient_name' => 'required|string',
            'patient_email' => 'required|email',
            'patient_telephone' => 'required|string',
        ]);

        // Vérifier si le patient existe déjà
        $user = User::where('email', $request->patient_email)->first();

        if (!$user) {
            // Créer automatiquement le patient
            $user = User::create([
                'name' => $request->patient_name,
                'email' => $request->patient_email,
                'password' => bcrypt('password123'),
                'role' => 'patient',
            ]);

            // Créer son dossier patient
            Patient::create([
                'user_id' => $user->id,
                'date_naissance' => $request->patient_date_naissance ?? null,
                'telephone' => $request->patient_telephone,
                'adresse' => $request->patient_adresse ?? null,
            ]);
        }

        // Récupérer le patient
        $patient = $user->patient;

        // Créer le rendez-vous
        RendezVous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $request->medecin_id,
            'date_heure' => $request->date_heure,
            'motif' => $request->motif,
            'statut' => 'en_attente',
        ]);

        return redirect()->route('dashboard')->with('success', 'Rendez-vous réservé avec succès ! Un compte patient a été créé.');
    }
    
    public function destroy($id)
    {
        $rdv = RendezVous::findOrFail($id);
        
        if ($rdv->patient_id != Auth::user()->patient->id) {
            abort(403);
        }
        
        $rdv->statut = 'annule';
        $rdv->save();
        
        return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous annulé avec succès.');
    }
    
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $patient = Auth::user()->patient;
        
        if (!$patient) {
            return redirect()->route('dashboard')->with('error', 'Vous devez compléter votre dossier patient.');
        }
        
        $rendezVous = RendezVous::where('patient_id', $patient->id)
            ->with('medecin.user')
            ->orderBy('date_heure', 'desc')
            ->get();
        
        return view('rendezvous.index', compact('rendezVous'));
    }
}