<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Planning extends Model
{
    use HasFactory;

    protected $fillable = ['medecin_id', 'jour', 'heure_debut', 'heure_fin', 'duree_consultation'];

    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }
}
