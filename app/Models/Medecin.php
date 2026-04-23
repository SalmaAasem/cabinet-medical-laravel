<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Medecin extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'specialite', 'diplome', 'annee_experience'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plannings()
    {
        return $this->hasMany(Planning::class);
    }

    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class);
    }
}
