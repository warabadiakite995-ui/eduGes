<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    protected $table = 'bulletins';

    protected $fillable = [
        'trimestre',
        'moyenne_generale',
        'rang',
        'appreciation',
        'eleve_id',    // Lien vers la table eleves
    ];

    // Relation : Un bulletin appartient à un élève
    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }
}