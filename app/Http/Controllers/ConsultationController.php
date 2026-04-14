<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\Consultation;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    public function index()
    {
        $medecin = Auth::user()->medecin;
        
        if (!$medecin) {
            return redirect()->route('dashboard')->with('error', 'Vous n\'avez pas de dossier médecin.');
        }
        
        $rendezVous = RendezVous::where('medecin_id', $medecin->id)
            ->with('patient.user', 'consultation')
            ->orderBy('date_heure', 'asc')
            ->get();
        
        return view('medecin.rendez-vous', compact('rendezVous'));
    }
    
    public function create($id)
    {
        $rendezVous = RendezVous::with('patient.user')->findOrFail($id);
        
        if ($rendezVous->medecin_id != Auth::user()->medecin->id) {
            abort(403);
        }
        
        return view('medecin.consultation', compact('rendezVous'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'rendez_vous_id' => 'required|exists:rendez_vous,id',
            'diagnostic' => 'required|string',
            'traitement' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        Consultation::create([
            'rendez_vous_id' => $request->rendez_vous_id,
            'diagnostic' => $request->diagnostic,
            'traitement' => $request->traitement,
            'notes' => $request->notes,
        ]);
        
        $rdv = RendezVous::find($request->rendez_vous_id);
        $rdv->statut = 'termine';
        $rdv->save();
        
        return redirect()->route('medecin.rendez-vous')->with('success', 'Consultation ajoutée avec succès !');
    }
    
  public function patients()
{
    $medecin = Auth::user()->medecin;
    
    // Récupérer les IDs des patients qui ont un rendez-vous avec ce médecin
    $patientsIds = RendezVous::where('medecin_id', $medecin->id)
        ->pluck('patient_id')
        ->unique();
    
    // Récupérer les patients correspondants
    $patients = Patient::with('user')
        ->whereIn('id', $patientsIds)
        ->get();
    
    return view('medecin.patients', compact('patients'));
}
}