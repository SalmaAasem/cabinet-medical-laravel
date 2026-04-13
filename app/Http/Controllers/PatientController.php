<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    // Afficher la liste des patients
    public function index()
    {
        $patients = Patient::with('user')->get();
        return view('patients.index', compact('patients'));
    }
    
    // Afficher le formulaire d'ajout
    public function create()
    {
        return view('patients.create');
    }
    
    // Enregistrer un nouveau patient
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|string',
            'date_naissance' => 'required|date',
            'adresse' => 'required|string',
        ]);
        
        // Créer l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password123'),
            'role' => 'patient',
        ]);
        
        // Créer le dossier patient
        Patient::create([
            'user_id' => $user->id,
            'date_naissance' => $request->date_naissance,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
        ]);
        
        return redirect()->route('patients.create')->with('success', 'Patient ajouté avec succès !');
    }
    // Mise à jour du dossier 
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'telephone' => 'required|string',
            'adresse' => 'required|string',
        ]);

        $patient->update($request->only(['telephone', 'adresse', 'date_naissance']));

        return redirect()->back()->with('success', 'Le dossier médical a été mis à jour avec succès.');
    }

    public function showHistorique($id)
    {
        // Récupérer le patient avec toutes ses consultations (Eloquent ORM)
        $patient = Patient::with(['consultations.medecin'])->findOrFail($id);

        // Vérification simple des rôles (pour la logique d'affichage)
        $user = Auth::user();
    
        return view('patients.historique', compact('patient', 'user'));
    }
}