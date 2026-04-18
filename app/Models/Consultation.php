<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = ['rendez_vous_id', 'patient_id', 'medecin_id', 'diagnostic', 'traitement', 'notes'];
    
    public function rendezVous()
    {
        return $this->belongsTo(RendezVous::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    
    public function medecin()
    {
        return $this->belongsTo(Medecin::class, 'medecin_id');
    }
}
