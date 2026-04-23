<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Patient::with('user');

        if ($search) {
            $query
                ->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")->orWhere('email', 'LIKE', "%{$search}%");
                })
                ->orWhere('telephone', 'LIKE', "%{$search}%");
        }

        $patients = $query->get();

        return view('patients.index', compact('patients', 'search'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
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

    public function edit($id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'telephone' => 'required|string',
            'adresse' => 'required|string',
            'date_naissance' => 'required|date',
        ]);

        try {
            $patient->user->update([
                'name' => $request->name,
            ]);

            $patient->update([
                'telephone' => $request->telephone,
                'adresse' => $request->adresse,
                'date_naissance' => $request->date_naissance,
            ]);

            return redirect()->route('patients.index')->with('success', 'Patient mis à jour avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la modification : ' . $e->getMessage());
        }
    }

    public function myHistory()
    {
        $patient = Patient::with(['user', 'consultations.rendezVous.medecin.user'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $consultations = $patient->consultations()->orderBy('created_at', 'desc')->get();

        return view('patients.historique', compact('patient', 'consultations'));
    }

    public function historique($id)
    {
        $user = Auth::user();

        $patient = Patient::with(['user', 'consultations.rendezVous.medecin.user', 'rendezVous.medecin.user'])->findOrFail($id);

        if ($user->role == 'secretaire') {
            return view('secretaire.patient_history', compact('patient'));
        }

        if ($user->role == 'medecin' || $user->role == 'admin') {
            return view('medecin.patient_history', compact('patient'));
        }

        return view('patients.historique', compact('patient'));
    }
}
