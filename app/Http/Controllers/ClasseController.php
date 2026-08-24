<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    // Affiche la liste des classes
    public function index()
    {
        $classes = Classe::latest()->get();
        return view('classes.index', compact('classes'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        return view('classes.create');
    }

    // Enregistre une nouvelle classe
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'nullable|string|max:255',
            'annee_scolaire' => 'nullable|string|max:255',
        ]);

        Classe::create($request->all());

        return redirect()->route('classes.index')->with('success', 'Classe ajoutée avec succès !');
    }

    // Affiche le formulaire de modification
    public function edit(Classe $classe)
    {
        return view('classes.edit', compact('classe'));
    }

    // Met à jour la classe
    public function update(Request $request, Classe $classe)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'niveau' => 'nullable|string|max:255',
            'annee_scolaire' => 'nullable|string|max:255',
        ]);

        $classe->update($request->all());

        return redirect()->route('classes.index')->with('success', 'Classe modifiée avec succès !');
    }

    // Supprime une classe
    public function destroy(Classe $classe)
    {
        $classe->delete();
        return redirect()->route('classes.index')->with('success', 'Classe supprimée avec succès !');
    }
}