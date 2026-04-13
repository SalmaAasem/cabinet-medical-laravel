<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = ['rendez_vous_id', 'diagnostic', 'traitement', 'notes'];
    
    public function rendezVous()
    {
        return $this->belongsTo(RendezVous::class);
    }

    public function medecin()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }
}