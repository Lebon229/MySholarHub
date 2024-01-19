<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $fillable = ['nom'];
    

    // Exemple de relation avec les élèves
    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }

    public function matieres()
    {
        return $this->belongsToMany(Matiere::class, 'classe_matiere', 'classe_id', 'matiere_id');
    }
    // Ajoute d'autres relations au besoin
}