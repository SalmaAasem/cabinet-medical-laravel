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

    // Rechercher un patient
    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $patients = Patient::with('user')
            ->whereHas('user', function($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->orWhere('telephone', 'like', '%' . $search . '%')
            ->get();
        
        return view('patients.index', compact('patients', 'search'));
    }
}