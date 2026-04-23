<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class RendezVous extends Model
{
    use HasFactory;
    
    protected $table = 'rendez_vous';

    protected $fillable = ['patient_id', 'medecin_id', 'date_heure', 'statut', 'motif', 'date_rdv', 'heure_rdv'];

    protected $casts = [
        'date_heure' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class, 'medecin_id');
    }

    public function consultation()
    {
        return $this->hasOne(Consultation::class, 'rendez_vous_id');
    }
}
