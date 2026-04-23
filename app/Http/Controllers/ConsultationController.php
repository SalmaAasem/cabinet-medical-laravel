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
            return redirect('/')->with('error', 'Accès refusé.');
        }

        $rendezVous = RendezVous::where('medecin_id', $medecin->id)
            ->with(['patient.user', 'consultation'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRDV = $rendezVous->count();
        $consultationsFaites = Consultation::where('medecin_id', $medecin->id)->count();

        return view('medecin.rendez-vous', compact('rendezVous', 'totalRDV', 'consultationsFaites'));
    }

    public function create($id)
    {
        $medecin = Auth::user()->medecin;
        $rendezVous = RendezVous::with('patient.user')->where('medecin_id', $medecin->id)->findOrFail($id);

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

        $rdv = RendezVous::findOrFail($request->rendez_vous_id);

        Consultation::create([
            'rendez_vous_id' => $rdv->id,
            'patient_id' => $rdv->patient_id,
            'medecin_id' => $rdv->medecin_id,
            'diagnostic' => $request->diagnostic,
            'traitement' => $request->traitement,
            'notes' => $request->notes,
        ]);

        $rdv->update(['statut' => 'Terminé']);

        return redirect()->route('medecin.rendez-vous')->with('success', 'Consultation enregistrée avec succès !');
    }
}
