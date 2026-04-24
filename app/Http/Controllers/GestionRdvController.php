<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RendezVous;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentConfirmed;

class GestionRdvController extends Controller
{
    public function index()
    {
        $rendezVous = RendezVous::with(['patient.user', 'medecin.user'])
            ->orderBy('date_heure', 'desc')
            ->get();
        return view('gestion-rdv.index', compact('rendezVous'));
    }

    public function update(Request $request, $id)
    {
        try {
            $rdv = RendezVous::with('patient.user')->findOrFail($id);
            $rdv->statut = $request->statut;
            $rdv->save();

            if ($rdv->statut === 'Confirmé' || $rdv->statut === 'confirme') {
                try {
                    Mail::to($rdv->patient->user->email)->send(new AppointmentConfirmed($rdv));
                } catch (\Exception $e) {
                    return back()->with('success', 'Statut changé mais l\'envoi de l\'email a échoué ' . $e->getMessage());
                }
            }

            return back()->with('success', 'Statut mis à jour avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->delete();
        return back()->with('success', 'Rendez-vous supprimé avec succès.');
    }
}
