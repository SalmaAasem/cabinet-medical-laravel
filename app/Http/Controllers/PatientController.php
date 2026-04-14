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
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password123'),
            'role' => 'patient',
        ]);
        
        Patient::create([
            'user_id' => $user->id,
            'date_naissance' => $request->date_naissance,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
        ]);
        
        return redirect()->route('patients.index')->with('success', 'Patient ajouté avec succès !');
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
    
    // Afficher le formulaire de modification
    public function edit($id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        return view('patients.edit', compact('patient'));
    }
    
    // Mettre à jour un patient
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $patient->user_id,
            'telephone' => 'required|string',
            'date_naissance' => 'required|date',
            'adresse' => 'required|string',
        ]);
        
        $user = User::find($patient->user_id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        $patient->update([
            'date_naissance' => $request->date_naissance,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
        ]);
        
        return redirect()->route('patients.index')->with('success', 'Patient modifié avec succès !');
    }
    
    // Supprimer un patient
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $user = User::find($patient->user_id);
        $user->delete();
        $patient->delete();
        
        return redirect()->route('patients.index')->with('success', 'Patient supprimé avec succès !');
    }
}