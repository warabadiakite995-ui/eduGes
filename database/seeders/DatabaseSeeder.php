<?php

namespace Database\Seeders;

use App\Models\Eleve;
use App\Models\Professeur;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Bulletin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Classes
        $classe6 = Classe::create(['nom' => '6ème A', 'niveau' => 'Primaire', 'annee_scolaire' => '2025-2026']);
        $classe5 = Classe::create(['nom' => '5ème B', 'niveau' => 'Collège', 'annee_scolaire' => '2025-2026']);

        // 2. Professeurs
        $prof1 = Professeur::create(['nom' => 'Dupont', 'prenom' => 'Jean', 'email' => 'jean.dupont@email.com', 'specialite' => 'Mathématiques']);
        $prof2 = Professeur::create(['nom' => 'Martin', 'prenom' => 'Sophie', 'email' => 'sophie.martin@email.com', 'specialite' => 'Français']);

        // 3. Matières
        $maths = Matiere::create(['nom' => 'Mathématiques', 'code' => 'MATH01', 'coefficient' => 4, 'professeur_id' => $prof1->id]);
        $francais = Matiere::create(['nom' => 'Français', 'code' => 'FR01', 'coefficient' => 3, 'professeur_id' => $prof2->id]);

        // 4. Élèves
        $eleve1 = Eleve::create(['nom' => 'Turing', 'prenom' => 'Alan', 'date_naissance' => '2010-01-01', 'classe_id' => $classe6->id]);
        $eleve2 = Eleve::create(['nom' => 'Curie', 'prenom' => 'Marie', 'date_naissance' => '2009-05-12', 'classe_id' => $classe6->id]);
        $eleve3 = Eleve::create(['nom' => 'Einstein', 'prenom' => 'Albert', 'date_naissance' => '2008-03-15', 'classe_id' => $classe5->id]);

        // 5. Notes
        Note::create(['valeur' => 14.5, 'trimestre' => '1', 'appreciation' => 'Très bon travail', 'eleve_id' => $eleve1->id, 'matiere_id' => $maths->id]);
        Note::create(['valeur' => 12.0, 'trimestre' => '1', 'appreciation' => 'Peut mieux faire', 'eleve_id' => $eleve1->id, 'matiere_id' => $francais->id]);
        Note::create(['valeur' => 18.0, 'trimestre' => '1', 'appreciation' => 'Excellent', 'eleve_id' => $eleve2->id, 'matiere_id' => $maths->id]);

        // 6. Bulletins
        Bulletin::create(['trimestre' => '1', 'moyenne_generale' => 13.25, 'rang' => 2, 'appreciation' => 'Bon semestre', 'eleve_id' => $eleve1->id]);
    }
}