<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    protected $fillable = ['user_id', 'specialite', 'diplome', 'annee_experience'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }
}