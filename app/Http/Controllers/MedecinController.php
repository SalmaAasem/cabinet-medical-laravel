<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Consultation;

class MedecinController extends Controller
{


public function listPatients() {
    $patients = \App\Models\Patient::all(); 
    return view('medecin.patients_list', compact('patients'));
}

// عرض تاريخ مريض معين
public function showHistory($id) {
    $patient = Patient::with(['consultations' => function($query) {
        $query->orderBy('created_at', 'desc');
    }])->findOrFail($id);

    return view('medecin.patient_history', compact('patient'));
}
}
