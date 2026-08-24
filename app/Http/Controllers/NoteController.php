<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\Eleve;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Note::with(['eleve', 'matiere', 'eleve.classe']);

        // Filtres
        if ($request->filled('classe_id')) {
            $query->whereHas('eleve', function ($q) use ($request) {
                $q->where('classe_id', $request->classe_id);
            });
        }

        if ($request->filled('matiere_id')) {
            $query->where('matiere_id', $request->matiere_id);
        }

        if ($request->filled('trimestre')) {
            $query->where('trimestre', $request->trimestre);
        }

        if ($request->filled('annee_scolaire')) {
            $query->where('annee_scolaire', $request->annee_scolaire);
        }

        if ($request->filled('eleve_id')) {
            $query->where('eleve_id', $request->eleve_id);
        }

        $notes = $query->latest()->paginate(20);

        // Récupération des données pour les filtres
        $classes = Classe::all();
        $matieres = Matiere::all();
        $eleves = Eleve::with('classe')->orderBy('nom')->get();
        $trimestres = ['T1', 'T2', 'T3'];

        // Récupération sécurisée des années
        $annees = Note::select('annee_scolaire')
            ->whereNotNull('annee_scolaire')
            ->distinct()
            ->orderBy('annee_scolaire', 'desc')
            ->pluck('annee_scolaire')
            ->toArray();

        // Si aucune année n'existe, utiliser l'année en cours
        if (empty($annees)) {
            $annees = [$this->getCurrentAcademicYear()];
        }

        return view('notes.index', compact('notes', 'classes', 'matieres', 'eleves', 'trimestres', 'annees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classe::all();
        $matieres = Matiere::all();
        $eleves = Eleve::all();
        $trimestres = ['T1', 'T2', 'T3'];
        $anneeScolaire = $this->getCurrentAcademicYear();

        return view('notes.create', compact('classes', 'matieres', 'eleves', 'trimestres', 'anneeScolaire'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'valeur' => 'required|numeric|min:0|max:20',
            'trimestre' => 'required|string',
            'annee_scolaire' => 'required|string',
            'appreciation' => 'nullable|string|max:255',
            'coef' => 'nullable|numeric|min:1|max:10',
        ]);

        Note::create($validated);

        return redirect()->route('notes.index')
            ->with('success', 'Note ajoutée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        $note->load(['eleve', 'matiere', 'eleve.classe']);
        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        $classes = Classe::all();
        $matieres = Matiere::all();
        $eleves = Eleve::all();
        $trimestres = ['T1', 'T2', 'T3'];
        
        return view('notes.edit', compact('note', 'classes', 'matieres', 'eleves', 'trimestres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id',
            'matiere_id' => 'required|exists:matieres,id',
            'valeur' => 'required|numeric|min:0|max:20',
            'trimestre' => 'required|string',
            'annee_scolaire' => 'required|string',
            'appreciation' => 'nullable|string|max:255',
            'coef' => 'nullable|numeric|min:1|max:10',
        ]);

        $note->update($validated);

        return redirect()->route('notes.index')
            ->with('success', 'Note modifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('notes.index')
            ->with('success', 'Note supprimée avec succès !');
    }

    /**
     * Saisie multiple des notes
     */
    public function saisieMultiple()
    {
        $classes = Classe::with('eleves')->get();
        $matieres = Matiere::all();
        $trimestres = ['T1', 'T2', 'T3'];
        $anneeScolaire = $this->getCurrentAcademicYear();

        return view('notes.saisie-multiple', compact('classes', 'matieres', 'trimestres', 'anneeScolaire'));
    }

    /**
     * Get current academic year
     */
    private function getCurrentAcademicYear()
    {
        $year = date('Y');
        $month = date('m');
        
        if ($month >= 9) {
            return $year . '-' . ($year + 1);
        }
        
        return ($year - 1) . '-' . $year;
    }
}