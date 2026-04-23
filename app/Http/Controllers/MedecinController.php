<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class MedecinController extends Controller
{
    public function listPatients()
    {
        $medecin = auth()->user()->medecin;

        if (!$medecin) {
            return back()->with('error', 'Vous n\'êtes pas enregistré en tant que médecin.');
        }

        $medecinId = $medecin->id;

        $patients = Patient::where(function ($query) use ($medecinId) {
            $query
                ->whereHas('rendezVous', function ($q) use ($medecinId) {
                    $q->where('rendez_vous.medecin_id', $medecinId);
                })

                ->orWhereHas('consultations', function ($q) use ($medecinId) {
                    $q->where('consultations.medecin_id', $medecinId);
                });
        })
            ->with('user')
            ->distinct()
            ->get();

        return view('medecin.patients_list', compact('patients'));
    }
    public function showHistory($id)
    {
        $patient = Patient::with([
            'consultations' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
        ])->findOrFail($id);

        return view('medecin.patient_history', compact('patient'));
    }

    public function showConsultation($id)
    {
        $consultation = Consultation::with(['patient.user', 'medecin.user'])->findOrFail($id);
        return view('medecin.consultation_detail', compact('consultation'));
    }

    public function downloadPDF($id)
    {
        $consultation = Consultation::with(['patient.user', 'medecin.user'])->findOrFail($id);

        $pdf = Pdf::loadView('ordonnance.pdf', compact('consultation'));

        return $pdf->download('Ordonnance_' . $consultation->patient->user->name . '.pdf');
    }

    public function storeConsultation(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'diagnostic' => 'required',
            'ordonnance' => 'required',
            'traitement' => 'required',
        ]);

        $consultation = Consultation::create([
            'patient_id' => $request->patient_id,
            'rendez_vous_id' => $request->rendez_vous_id,
            'medecin_id' => Auth::user()->medecin->id,
            'diagnostic' => $request->diagnostic,
            'traitement' => $request->traitement,
            'notes' => $request->notes,
            'date_consultation' => now(),
        ]);
        $consultation->load(['patient.user', 'medecin.user']);

        $pdf = Pdf::loadView('medecin.pdf', compact('consultation'));

        return $pdf->download('Ordonnance_' . $consultation->patient->user->name . '.pdf');
    }
}
