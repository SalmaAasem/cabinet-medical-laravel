<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    public function index()
{
    $medecin = Auth::user()->medecin;
    
    if (!$medecin) {
        return redirect()->route('dashboard')->with('error', 'Vous n\'avez pas de dossier médecin. Contactez l\'administrateur.');
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
        
        // Vérifier que le médecin connecté est bien celui du rendez-vous
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
        
        // Mettre à jour le statut du rendez-vous
        $rdv = RendezVous::find($request->rendez_vous_id);
        $rdv->statut = 'termine';
        $rdv->save();
        
        return redirect()->route('medecin.rendez-vous')->with('success', 'Consultation ajoutée avec succès !');
    }
}