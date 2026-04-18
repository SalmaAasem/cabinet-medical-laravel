<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    // Display a listing of patients
    public function index()
    {
        $patients = Patient::with('user')->get();
        return view('patients.index', compact('patients'));
    }
    
    // Show the form for creating a new patient
    public function create()
    {
        return view('patients.create');
    }
    
    // Store a newly created patient in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|string',
            'date_naissance' => 'required|date',
            'adresse' => 'required|string',
        ]);
        
        // Create the user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password123'),
            'role' => 'patient',
        ]);
        
        // Create the patient profile
        Patient::create([
            'user_id' => $user->id,
            'date_naissance' => $request->date_naissance,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
        ]);
        
        return redirect()->route('patients.index')->with('success', 'Patient ajouté avec succès !');
    }

    // Show the form for editing the patient
    public function edit($id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    // Update the patient in storage
    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $request->validate([
            'telephone' => 'required|string',
            'adresse' => 'required|string',
            'date_naissance' => 'required|date',
        ]);

        $patient->update($request->only(['telephone', 'adresse', 'date_naissance']));

        return redirect()->route('patients.index')->with('success', 'Le dossier médical a été mis à jour avec succès.');
    }

    // Display the medical history of a patient
    public function myHistory()
    {
        // Load patient with consultations and doctors
        $patient = Patient::with(['user', 'consultations.medecin.user'])
        ->where('user_id', Auth::id())
        ->firstOrFail();
        $consultations = $patient->consultations; 

        $user = Auth::user();

        return view('patients.historique', compact('patient', 'consultations', 'user'));
    }
    
    // هاد الدالة خاصة بالسكريتيرة باش تشوف تاريخ أي مريض عن طريق الـ ID ديالو
public function historique($id)
{
    // كنجيبو المريض بالـ ID ديالو مع الاستشارات
    $patient = Patient::with(['user', 'consultations.medecin.user'])->findOrFail($id);
    
    // كنجيبو الاستشارات مرتبة من الأحدث
    $consultations = $patient->consultations()->orderBy('created_at', 'desc')->get();

    // كنصيفطوهم لنفس الـ View اللي صاوبنا
    return view('patients.historique', compact('patient', 'consultations'));
}

    // Search for patients
    public function search(Request $request)
    {
        $search = $request->input('search');

        $patients = Patient::whereHas('user', function($query) use ($search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
        })->orWhere('telephone', 'like', "%$search%")->get();

        return view('patients.index', compact('patients', 'search'));
    }
}