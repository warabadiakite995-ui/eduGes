<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    // Nom de la table (optionnel si vous suivez la convention "eleves")
    protected $table = 'eleves';

    // Autorise l'insertion massive de ces champs
    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'classe_id', // Lien vers la table classes
    ];

    // Relation : Un élève appartient à une classe
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    // Relation : Un élève a plusieurs notes
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    // Relation : Un élève a plusieurs bulletins
    public function bulletins()
    {
        return $this->hasMany(Bulletin::class);
    }
}