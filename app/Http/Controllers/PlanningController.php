<?php

namespace App\Http\Controllers;

use App\Models\Planning;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PlanningController extends Controller
{


    public function index()
    {
    $medecinId = auth()->user()->medecin->id; 
    $plannings = Planning::where('medecin_id', $medecinId)->get();

    return view('medecin.planning', compact('plannings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jour' => 'required',
            'heure_debut' => 'required',
            'heure_fin' => 'required|after:heure_debut',
            'duree_consultation' => 'required|integer|min:10',
        ]);

        $medecinId = auth()->user()->medecin->id; 

        Planning::updateOrCreate(
            [
                'medecin_id' => $medecinId,
                'jour' => $request->jour
            ],
            [
                'heure_debut' => $request->heure_debut,
                'heure_fin' => $request->heure_fin,
                'duree_consultation' => $request->duree_consultation,
            ]
        );

        return back()->with('success', 'Planning mis à jour avec succès !');
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'medecin_id' => 'required|exists:medecins,id',
        ]);

        $date = $request->date;
        $medecinId = $request->medecin_id;
        $jourSemaine = Carbon::parse($date)->format('l');

        $planning = Planning::where('medecin_id', $medecinId)->where('jour', $jourSemaine)->first();

        if (!$planning) {
            return response()->json(['message' => 'Le médecin ne travaille pas ce jour-là'], 200);
        }

        $bookedSlots = RendezVous::where('medecin_id', $medecinId)->whereDate('date_rdv', $date)->pluck('heure_rdv')->map(fn($time) => Carbon::parse($time)->format('H:i'))->toArray();

        $slots = [];
        $start = Carbon::parse($planning->heure_debut);
        $end = Carbon::parse($planning->heure_fin);

        while ($start->copy()->addMinutes($planning->duree_consultation) <= $end) {
            $time = $start->format('H:i');

            if (!in_array($time, $bookedSlots)) {
                $slots[] = $time;
            }
            $start->addMinutes($planning->duree_consultation);
        }

        return response()->json($slots);
    }
}
