<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'nom',
        'niveau',
        'annee_scolaire',
    ];

    // Relation : Une classe a plusieurs élèves
    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }
}