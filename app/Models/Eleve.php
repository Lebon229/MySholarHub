<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    protected $fillable = ['nom', 'prenoms', 'matricule', 'classe_id'];
    
    // Exemple de relation avec les notes
    public function notes()
    {
        return $this->hasMany(Note::class, 'id_eleve');
    }

    public function classe()
    {
        return $this->belongsTo('App\Models\Classe');
    }
    // Ajoute d'autres relations au besoin
}