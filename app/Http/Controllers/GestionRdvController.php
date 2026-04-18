<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RendezVous;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\AppointmentConfirmation; 

class GestionRdvController extends Controller
{
    public function index()
    {

        $rendezVous = RendezVous::with(['patient.user', 'medecin.user'])->orderBy('date_heure', 'desc')->get();
        return view('gestion-rdv.index', compact('rendezVous'));
    }

    public function update(Request $request, $id)
    {
        try {
            $rdv = RendezVous::findOrFail($id);
            $rdv->statut = $request->statut;
            $rdv->save();

            if ($rdv->statut === 'confirme') {
                Mail::to($rdv->patient->user->email)->send(new \App\Mail\AppointmentConfirmed($rdv));
            }

            return response()->json(['message' => 'Statut mis à jour avec succès'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->delete();
        return back()->with('success', 'Rendez-vous annulé et supprimé.');
    }
}