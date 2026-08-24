<!-- resources/views/notes/create.blade.php -->

@extends('layouts.app')

@section('title', 'Ajouter une note')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i> Ajouter une note
                    </h4>
                    <a href="{{ route('notes.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                    </a>
                </div>

                <div class="card-body">
                    <!-- Affichage des erreurs de validation -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5 class="alert-heading">
                                <i class="fas fa-exclamation-circle me-2"></i> Des erreurs ont été détectées
                            </h5>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Message de succès ou d'erreur -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Formulaire -->
                    <form action="{{ route('notes.store') }}" method="POST" id="noteForm">
                        @csrf

                        <div class="row">
                            <!-- Colonne gauche -->
                            <div class="col-md-6">
                                <!-- Sélection de l'élève -->
                                <div class="mb-3">
                                    <label for="eleve_id" class="form-label fw-bold">
                                        Élève <span class="text-danger">*</span>
                                    </label>
                                    <select name="eleve_id" id="eleve_id" 
                                            class="form-select @error('eleve_id') is-invalid @enderror" 
                                            required>
                                        <option value="">-- Sélectionnez un élève --</option>
                                        @foreach($eleves as $eleve)
                                            <option value="{{ $eleve->id }}" 
                                                    {{ old('eleve_id') == $eleve->id ? 'selected' : '' }}
                                                    data-classe="{{ $eleve->classe->nom ?? 'Non affecté' }}">
                                                {{ $eleve->matricule }} - {{ $eleve->nom_complet }}
                                                @if($eleve->classe)
                                                    ({{ $eleve->classe->nom }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('eleve_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i> 
                                        Sélectionnez l'élève pour lequel vous souhaitez saisir une note.
                                    </small>
                                </div>

                                <!-- Sélection de la matière -->
                                <div class="mb-3">
                                    <label for="matiere_id" class="form-label fw-bold">
                                        Matière <span class="text-danger">*</span>
                                    </label>
                                    <select name="matiere_id" id="matiere_id" 
                                            class="form-select @error('matiere_id') is-invalid @enderror" 
                                            required>
                                        <option value="">-- Sélectionnez une matière --</option>
                                        @foreach($matieres as $matiere)
                                            <option value="{{ $matiere->id }}" 
                                                    {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                                {{ $matiere->nom }}
                                                @if($matiere->code)
                                                    ({{ $matiere->code }})
                                                @endif
                                                @if($matiere->coef_defaut)
                                                    - Coef: {{ $matiere->coef_defaut }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('matiere_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i> 
                                        Sélectionnez la matière concernée.
                                    </small>
                                </div>

                                <!-- Saisie de la note -->
                                <div class="mb-3">
                                    <label for="valeur" class="form-label fw-bold">
                                        Note <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="number" 
                                               name="valeur" 
                                               id="valeur" 
                                               class="form-control @error('valeur') is-invalid @enderror" 
                                               value="{{ old('valeur') }}"
                                               min="0" 
                                               max="20" 
                                               step="0.5"
                                               placeholder="Ex: 14.5"
                                               required>
                                        <span class="input-group-text">/ 20</span>
                                    </div>
                                    @error('valeur')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i> 
                                        La note doit être comprise entre 0 et 20, avec un pas de 0.5.
                                    </small>
                                </div>

                                <!-- Coefficient -->
                                <div class="mb-3">
                                    <label for="coef" class="form-label fw-bold">
                                        Coefficient
                                    </label>
                                    <input type="number" 
                                           name="coef" 
                                           id="coef" 
                                           class="form-control @error('coef') is-invalid @enderror" 
                                           value="{{ old('coef', 1) }}"
                                           min="1" 
                                           max="5" 
                                           step="1">
                                    @error('coef')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i> 
                                        Coefficient par défaut : 1. Modifiez si nécessaire.
                                    </small>
                                </div>
                            </div>

                            <!-- Colonne droite -->
                            <div class="col-md-6">
                                <!-- Sélection du trimestre -->
                                <div class="mb-3">
                                    <label for="trimestre" class="form-label fw-bold">
                                        Trimestre <span class="text-danger">*</span>
                                    </label>
                                    <select name="trimestre" id="trimestre" 
                                            class="form-select @error('trimestre') is-invalid @enderror" 
                                            required>
                                        <option value="">-- Sélectionnez un trimestre --</option>
                                        @foreach($trimestres as $trimestre)
                                            <option value="{{ $trimestre }}" 
                                                    {{ old('trimestre') == $trimestre ? 'selected' : '' }}>
                                                {{ $trimestre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('trimestre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Année scolaire -->
                                <div class="mb-3">
                                    <label for="annee_scolaire" class="form-label fw-bold">
                                        Année scolaire <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           name="annee_scolaire" 
                                           id="annee_scolaire" 
                                           class="form-control @error('annee_scolaire') is-invalid @enderror" 
                                           value="{{ old('annee_scolaire', $annee_scolaire) }}"
                                           placeholder="Ex: 2025-2026"
                                           required>
                                    @error('annee_scolaire')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i> 
                                        Format : AAAA-AAAA (ex: 2025-2026)
                                    </small>
                                </div>

                                <!-- Appréciation -->
                                <div class="mb-3">
                                    <label for="appreciation" class="form-label fw-bold">
                                        Appréciation
                                    </label>
                                    <textarea name="appreciation" 
                                              id="appreciation" 
                                              class="form-control @error('appreciation') is-invalid @enderror" 
                                              rows="3"
                                              placeholder="Saisissez une appréciation ou laissez vide pour une génération automatique">{{ old('appreciation') }}</textarea>
                                    @error('appreciation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i> 
                                        Laissez vide pour une appréciation automatique basée sur la note.
                                    </small>
                                </div>

                                <!-- Aperçu de l'appréciation automatique -->
                                <div class="mb-3" id="apercuAppreciation" style="display: none;">
                                    <div class="alert alert-info">
                                        <i class="fas fa-lightbulb me-2"></i>
                                        <strong>Appréciation suggérée :</strong>
                                        <span id="appreciationSuggeree"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save me-2"></i> Enregistrer
                                        </button>
                                        <button type="reset" class="btn btn-secondary">
                                            <i class="fas fa-undo me-2"></i> Réinitialiser
                                        </button>
                                    </div>
                                    <a href="{{ route('notes.index') }}" class="btn btn-danger">
                                        <i class="fas fa-times me-2"></i> Annuler
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Information supplémentaire -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="fas fa-info-circle text-primary me-2"></i> Informations importantes
                    </h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-1">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Une note ne peut être saisie qu'une seule fois par élève, matière, trimestre et année scolaire.
                        </li>
                        <li class="mb-1">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            La note doit être comprise entre <strong>0</strong> et <strong>20</strong>.
                        </li>
                        <li class="mb-1">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            L'appréciation est générée automatiquement si vous ne la remplissez pas.
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Éléments du formulaire
        const noteInput = document.getElementById('valeur');
        const appreciationInput = document.getElementById('appreciation');
        const apercuDiv = document.getElementById('apercuAppreciation');
        const appreciationSuggeree = document.getElementById('appreciationSuggeree');

        // Fonction pour générer l'appréciation
        function genererAppreciation(note) {
            if (note === null || note === '' || isNaN(note)) {
                return '';
            }
            
            note = parseFloat(note);
            
            if (note >= 18) {
                return 'Excellent travail, performance exceptionnelle !';
            } else if (note >= 16) {
                return 'Très bon travail, félicitations !';
            } else if (note >= 14) {
                return 'Bon travail, continuez ainsi.';
            } else if (note >= 12) {
                return 'Travail satisfaisant, des progrès sont possibles.';
            } else if (note >= 10) {
                return 'Résultats moyens, un peu plus d\'efforts sont nécessaires.';
            } else if (note >= 8) {
                return 'Résultats insuffisants, travaillez davantage.';
            } else if (note >= 6) {
                return 'Résultats faibles, un soutien est recommandé.';
            } else if (note >= 0) {
                return 'Résultats très faibles, une aide est vivement conseillée.';
            }
            return '';
        }

        // Fonction pour mettre à jour l'aperçu
        function updateApercu() {
            const note = noteInput.value;
            const appreciation = genererAppreciation(note);
            
            if (appreciation && !appreciationInput.value.trim()) {
                appreciationSuggeree.textContent = appreciation;
                apercuDiv.style.display = 'block';
            } else {
                apercuDiv.style.display = 'none';
            }
        }

        // Événements
        noteInput.addEventListener('input', updateApercu);

        // Si l'utilisateur saisit une appréciation, on cache l'aperçu
        appreciationInput.addEventListener('input', function() {
            if (this.value.trim()) {
                apercuDiv.style.display = 'none';
            } else {
                updateApercu();
            }
        });

        // Vérification initiale
        updateApercu();

        // Validation du formulaire avant soumission
        document.getElementById('noteForm').addEventListener('submit', function(e) {
            const note = parseFloat(noteInput.value);
            
            if (isNaN(note) || note < 0 || note > 20) {
                e.preventDefault();
                alert('La note doit être comprise entre 0 et 20.');
                noteInput.focus();
                return false;
            }
            
            return true;
        });

        // Confirmation avant soumission si note < 5
        document.getElementById('noteForm').addEventListener('submit', function(e) {
            const note = parseFloat(noteInput.value);
            
            if (!isNaN(note) && note < 5) {
                if (!confirm('La note est très faible (' + note + '/20). Êtes-vous sûr de vouloir l\'enregistrer ?')) {
                    e.preventDefault();
                    return false;
                }
            }
            return true;
        });

        // Sélecteur de matière -> suggestion du coefficient
        document.getElementById('matiere_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const coefDefaut = selectedOption.getAttribute('data-coef');
            
            if (coefDefaut) {
                document.getElementById('coef').value = coefDefaut;
            }
        });

        // Gestion du bouton reset
        document.querySelector('button[type="reset"]').addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Voulez-vous vraiment réinitialiser tous les champs ?')) {
                document.getElementById('noteForm').reset();
                apercuDiv.style.display = 'none';
                // Réinitialiser les valeurs par défaut
                document.getElementById('coef').value = 1;
            }
        });

        // Empêcher l'entrée de caractères non numériques
        noteInput.addEventListener('keydown', function(e) {
            // Autoriser : chiffres, point, virgule, backspace, delete, tab, enter
            const key = e.key;
            if (!/^[\d.,]$/.test(key) && 
                key !== 'Backspace' && key !== 'Delete' && 
                key !== 'Tab' && key !== 'Enter' && 
                !e.ctrlKey && !e.metaKey) {
                e.preventDefault();
            }
        });

        // Formatage du champ année scolaire
        document.getElementById('annee_scolaire').addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 4) {
                value = value.substring(0, 4) + '-' + value.substring(4, 8);
            }
            this.value = value;
        });
    });
</script>

<!-- Style personnalisé -->
<style>
    .form-label {
        font-weight: 600;
        color: #2c3e50;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    
    .card {
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    }
    
    .card-header {
        border-radius: 12px 12px 0 0;
    }
    
    .alert {
        border-radius: 10px;
    }
    
    .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
    }
    
    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .form-control.is-invalid:focus, .form-select.is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    #apercuAppreciation {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .text-danger {
        font-weight: 700;
    }
    
    .list-unstyled li {
        padding: 4px 0;
        font-size: 0.95rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 10px;
        }
        
        .d-flex.justify-content-between div {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .btn {
            width: 100%;
        }
    }
</style>
@endsection