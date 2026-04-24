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
    public function create(Request $request)
    {
        $medecins = \App\Models\Medecin::with('user')->get();

        $selected_patient_id = $request->get('patient_id');

        $patients = \App\Models\Patient::with('user')->get();
        return view('rendezvous.create', compact('medecins', 'patients', 'selected_patient_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'patient_id' => 'nullable|exists:patients,id',
            'date_rdv' => 'required|date',
            'heure_rdv' => 'required',
            'motif' => 'nullable|string',
        ]);

        $jourSemaine = \Carbon\Carbon::parse($request->date_rdv)->format('l');

        $planning = \App\Models\Planning::where('medecin_id', $request->medecin_id)->where('jour', $jourSemaine)->whereTime('heure_debut', '<=', $request->heure_rdv)->whereTime('heure_fin', '>=', $request->heure_rdv)->first();

        if (!$planning) {
            return back()
                ->withErrors(['error' => "Le médecin n'est pas disponible le $jourSemaine à " . $request->heure_rdv])
                ->withInput();
        }

        $dejaPris = \App\Models\RendezVous::where('medecin_id', $request->medecin_id)->where('date_rdv', $request->date_rdv)->where('heure_rdv', $request->heure_rdv)->exists();

        if ($dejaPris) {
            return back()
                ->withErrors(['error' => 'Ce créneau est déjà réservé.'])
                ->withInput();
        }

        if (auth()->user()->role == 'patient') {
            $patientId = auth()->user()->patient->id;
        } else {
            $patientId = $request->input('patient_id');
        }

        if (!$patientId) {
            return back()->withErrors(['error' => 'Erreur: Aucun patient sélectionné.']);
        }


$rdv = \App\Models\RendezVous::create([
    'patient_id' => $patientId,
    'medecin_id' => $request->medecin_id,
    'date_rdv' => $request->date_rdv,
    'heure_rdv' => $request->heure_rdv,
    'date_heure' => $request->date_rdv . ' ' . $request->heure_rdv,
    'motif' => $request->motif,
    'statut' => 'en_attente',
]);

$user = auth()->user()->role == 'patient' ? auth()->user() : $rdv->patient->user;

\Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AppointmentConfirmation($rdv));  

    return redirect()->route('rendez-vous.index')->with('success', 'Rendez-vous ajouté !');
    }

    public function index()
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return redirect()->route('dashboard')->with('error', 'Profil patient non trouvé.');
        }

        $rendezVous = RendezVous::where('patient_id', $patient->id)->with('medecin.user')->orderBy('date_heure', 'asc')->get();

        return view('rendezvous.index', compact('rendezVous'));
    }

    public function destroy($id)
    {
        $rdv = RendezVous::findOrFail($id);

        if ($rdv->patient_id != Auth::user()->patient->id) {
            abort(403, 'Action non autorisée.');
        }

        $rdv->delete();

        return redirect()->route('rendez-vous.index')->with('success', 'Le rendez-vous a été supprimé avec succès.');
    }
}
