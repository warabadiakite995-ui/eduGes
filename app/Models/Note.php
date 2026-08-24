<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';

    protected $fillable = [
        'valeur',
        'trimestre',
        'eleve_id',    // Lien vers la table eleves
        'matiere_id',  // Lien vers la table matieres
    ];

    // Relation : Une note appartient à un élève
    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    // Relation : Une note appartient à une matière
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
}