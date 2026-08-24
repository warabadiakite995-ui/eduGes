<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
use App\Models\Eleve;
use Illuminate\Http\Request;

class BulletinController extends Controller
{
    // Affiche la liste des bulletins
    public function index()
    {
        // On charge les bulletins avec les infos de l'élève associé
        $bulletins = Bulletin::with('eleve')->latest()->get();
        return view('bulletins.index', compact('bulletins'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        // On a besoin de la liste des élèves pour le menu déroulant
        $eleves = Eleve::all();
        return view('bulletins.create', compact('eleves'));
    }

    // Enregistre un nouveau bulletin
    public function store(Request $request)
    {
        $request->validate([
            'trimestre' => 'required|string|max:255',
            'moyenne_generale' => 'required|numeric',
            'rang' => 'required|integer',
            'appreciation' => 'nullable|string',
            'eleve_id' => 'required|exists:eleves,id',
        ]);

        Bulletin::create($request->all());

        return redirect()->route('bulletins.index')->with('success', 'Bulletin ajouté avec succès !');
    }

    // Affiche le formulaire de modification
    public function edit(Bulletin $bulletin)
    {
        $eleves = Eleve::all();
        return view('bulletins.edit', compact('bulletin', 'eleves'));
    }

    // Met à jour le bulletin
    public function update(Request $request, Bulletin $bulletin)
    {
        $request->validate([
            'trimestre' => 'required|string|max:255',
            'moyenne_generale' => 'required|numeric',
            'rang' => 'required|integer',
            'appreciation' => 'nullable|string',
            'eleve_id' => 'required|exists:eleves,id',
        ]);

        $bulletin->update($request->all());

        return redirect()->route('bulletins.index')->with('success', 'Bulletin modifié avec succès !');
    }

    // Supprime un bulletin
    public function destroy(Bulletin $bulletin)
    {
        $bulletin->delete();
        return redirect()->route('bulletins.index')->with('success', 'Bulletin supprimé avec succès !');
    }
}