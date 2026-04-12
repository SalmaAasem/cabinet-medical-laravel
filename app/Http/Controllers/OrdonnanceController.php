<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Barryvdh\DomPDF\Facade\Pdf;

class OrdonnanceController extends Controller
{
    public function pdf($consultationId)
    {
        $consultation = Consultation::with('rendezVous.medecin.user', 'rendezVous.patient.user')->findOrFail($consultationId);
        
        $pdf = PDF::loadView('ordonnance.pdf', compact('consultation'));
        
        return $pdf->download('ordonnance_' . $consultationId . '.pdf');
    }
}