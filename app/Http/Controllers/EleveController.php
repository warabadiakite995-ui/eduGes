<?php

namespace App\Http\Controllers;

use App\Models\Eleve;
use Illuminate\Http\Request;

class EleveController extends Controller
{
    // Affiche la liste
    public function index()
    {
        $eleves = Eleve::with('classe')->latest()->get();
        return view('eleves.index', compact('eleves'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('eleves.create');
    }

    // Enregistre un nouvel élève
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'classe_id' => 'required|exists:classes,id',
        ]);

        Eleve::create($request->all());

        return redirect()->route('eleves.index')->with('success', 'Élève ajouté avec succès !');
    }

    // Affiche le formulaire de modification
    public function edit(Eleve $eleve)
    {
        return view('eleves.edit', compact('eleve'));
    }

    // Met à jour l'élève
    public function update(Request $request, Eleve $eleve)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'classe_id' => 'required|exists:classes,id',
        ]);

        $eleve->update($request->all());

        return redirect()->route('eleves.index')->with('success', 'Élève modifié avec succès !');
    }

    // Supprime un élève
    public function destroy(Eleve $eleve)
    {
        $eleve->delete();
        return redirect()->route('eleves.index')->with('success', 'Élève supprimé avec succès !');
    }
}