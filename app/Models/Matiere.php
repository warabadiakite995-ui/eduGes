<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    protected $table = 'matieres';

    protected $fillable = [
        'nom',
        'code',
        'coefficient',
        'professeur_id', // Lien vers la table professeurs
    ];

    // Relation : Une matière appartient à un professeur
    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }

    // Relation : Une matière a plusieurs notes
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}