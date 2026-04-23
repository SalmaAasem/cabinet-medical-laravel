<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date_naissance', 'telephone', 'adresse', 'num_secu'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function consultations()
    {
        return $this->hasManyThrough(Consultation::class, RendezVous::class, 'patient_id', 'rendez_vous_id', 'id', 'id');
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class, 'patient_id', 'id');
    }
}
