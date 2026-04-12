<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GestionRdvController extends Controller
{
    public function index()
    {
        $rendezVous = RendezVous::with('patient.user', 'medecin.user')
            ->orderBy('date_heure', 'desc')
            ->get();
        
        return view('gestion-rdv.index', compact('rendezVous'));
    }
    
    public function update(Request $request, $id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->statut = $request->statut;
        $rdv->save();
        
        return redirect()->route('gestion-rdv.index')->with('success', 'Statut mis à jour');
    }
    
    public function destroy($id)
    {
        $rdv = RendezVous::findOrFail($id);
        $rdv->delete();
        
        return redirect()->route('gestion-rdv.index')->with('success', 'Rendez-vous annulé');
    }
}