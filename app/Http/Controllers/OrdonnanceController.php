<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdonnanceController extends Controller
{
    public function pdf($consultationId)
    {
        $consultation = Consultation::with(['patient.user', 'medecin.user'])->findOrFail($consultationId);

        $pdf = PDF::loadView('ordonnance.pdf', compact('consultation'));

        return $pdf->stream('ordonnance_' . $consultation->patient->user->name . '.pdf');
    }
}
