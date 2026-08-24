<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\BulletinController;

// --- Page d'accueil (Redirection vers le dashboard) ---
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// --- Tableau de bord (Une seule route suffit) ---
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// --- Routes CRUD pour toutes les entités ---
Route::resource('eleves', EleveController::class)->parameters([
    'eleves' => 'eleve'
]);
Route::resource('classes', ClasseController::class);
Route::resource('matieres', MatiereController::class);
Route::resource('professeurs', ProfesseurController::class);
Route::resource('notes', NoteController::class);
Route::resource('bulletins', BulletinController::class);