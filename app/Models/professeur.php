<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    protected $table = 'professeurs';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'specialite',
    ];

    // Relation : Un professeur peut enseigner plusieurs matières (si c'est une relation ManyToMany, utilisez belongsToMany)
    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }
}