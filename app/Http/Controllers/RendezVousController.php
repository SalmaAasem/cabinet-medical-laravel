<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\RendezVous;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmation; 

class RendezVousController extends Controller
{

    public function create()
    {
       
        $medecins = Medecin::with('user')->get();
        return view('rendezvous.create', compact('medecins'));
    }
    

    public function store(Request $request)
    {
        
        $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'date_heure' => 'required|date|after:now', 
            'motif'      => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $patient = $user->patient;

        if (!$patient) {
            return redirect()->route('dashboard')->with('error', 'Dossier patient introuvable.');
        }

        $appointment = RendezVous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $request->medecin_id,
            'date_heure' => $request->date_heure,
            'motif'      => $request->motif,
            'statut'     => 'en_attente',
        ]);

        Mail::to($user->email)->send(new AppointmentConfirmation($appointment));

        
        // 5. Success
        return redirect()->route('rendez-vous.index')->with('success', 'Votre rendez-vous a été enregistré. Un email de confirmation vous a été envoyé.');
    }

    
    public function index()
    {
        $patient = Auth::user()->patient;
        
        if (!$patient) {
            return redirect()->route('dashboard')->with('error', 'Profil patient non trouvé.');
        }
        
        $rendezVous = RendezVous::where('patient_id', $patient->id)
            ->with('medecin.user')
            ->orderBy('date_heure', 'asc')
            ->get();
        
        return view('rendezvous.index', compact('rendezVous'));
    }

    /**
     * حذف أو إلغاء الموعد
     */
    public function destroy($id)
    {
        $rdv = RendezVous::findOrFail($id);
        
        // حماية: المريض يقدر يمسح غير المواعيد ديالو هو فقط
        if ($rdv->patient_id != Auth::user()->patient->id) {
            abort(403, 'Action non autorisée.');
        }
        
        $rdv->delete();
        
        return redirect()->route('rendez-vous.index')->with('success', 'Le rendez-vous a été supprimé avec succès.');
    }
}