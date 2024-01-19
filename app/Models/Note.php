<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
                            'classe_id',
                            'id_eleve',
                            'id_matiere',
                            'interro_1',
                            'interro_2',
                            'interro_3',
                            'interro_4',
                            'devoir_1',
                            'devoir_2',
                          ];

    // Exemple de relation avec l'élève
    public function eleve()
    {
        return $this->belongsTo(Eleve::class, 'id_eleve');
    }

    // Exemple de relation avec la matière
    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'id_matiere');
    }
    

    public function getOrCreateNoteForEleveAndMatiere($eleveId, $matiereId)
{
    return $this->firstOrNew([
        'id_eleve' => $eleveId,
        'id_matiere' => $matiereId,
    ]);
}


    public function classe()
{
    return $this->belongsTo(Classe::class, 'classe_id');
}

    // Ajoute d'autres relations au besoin
}