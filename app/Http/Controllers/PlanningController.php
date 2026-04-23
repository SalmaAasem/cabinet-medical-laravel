<?php

namespace App\Http\Controllers;

use App\Models\Planning;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PlanningController extends Controller
{
    /**
     * كيجيب السوايع اللي متاحين عند واحد الطبيب في نهار محدد
     */
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
