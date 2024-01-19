<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    protected $fillable = ['nom', 'coefficient', 'classe_id'];

    // Exemple de relation avec les notes
    public function notes()
    {
        return $this->hasMany(Note::class, 'id_matiere');
    }

    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'classe_matiere', 'matiere_id', 'classe_id');
    }

    // Ajoute d'autres relations au besoin
}