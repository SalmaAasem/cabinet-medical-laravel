<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['user_id', 'date_naissance', 'telephone', 'adresse', 'num_secu'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class); 
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }
}
