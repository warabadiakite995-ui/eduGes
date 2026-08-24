{{-- resources/views/notes/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Gestion des notes')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- En-tête -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">
                    <i class="fas fa-chart-bar text-primary me-2"></i> Gestion des notes
                </h1>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('notes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Ajouter une note
                    </a>
                    @if(Route::has('notes.saisie-multiple'))
                    <a href="{{ route('notes.saisie-multiple') }}" class="btn btn-success">
                        <i class="fas fa-edit me-1"></i> Saisie multiple
                    </a>
                    @endif
                    @if(Route::has('notes.statistiques'))
                    <a href="{{ route('notes.statistiques', ['classe_id' => request('classe_id')]) }}" class="btn btn-info">
                        <i class="fas fa-chart-pie me-1"></i> Statistiques
                    </a>
                    @endif
                    <button type="button" class="btn btn-secondary" onclick="window.location.reload();">
                        <i class="fas fa-sync-alt me-1"></i> Rafraîchir
                    </button>
                </div>
            </div>

            <!-- Messages flash -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Filtres -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-filter me-2"></i> Filtres
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('notes.index') }}" method="GET" id="filterForm">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="classe_id" class="form-label fw-bold">Classe</label>
                                <select name="classe_id" id="classe_id" class="form-select">
                                    <option value="">Toutes les classes</option>
                                    @isset($classes)
                                        @foreach($classes as $classe)
                                            <option value="{{ $classe->id }}" 
                                                    {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                                {{ $classe->nom ?? 'Classe' }}
                                                @if(isset($classe->effectif))
                                                    ({{ $classe->effectif }} élèves)
                                                @endif
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label for="matiere_id" class="form-label fw-bold">Matière</label>
                                <select name="matiere_id" id="matiere_id" class="form-select">
                                    <option value="">Toutes les matières</option>
                                    @isset($matieres)
                                        @foreach($matieres as $matiere)
                                            <option value="{{ $matiere->id }}" 
                                                    {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                                {{ $matiere->nom ?? 'Matière' }}
                                                @if(isset($matiere->code))
                                                    ({{ $matiere->code }})
                                                @endif
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="trimestre" class="form-label fw-bold">Trimestre</label>
                                <select name="trimestre" id="trimestre" class="form-select">
                                    <option value="">Tous</option>
                                    @isset($trimestres)
                                        @foreach($trimestres as $trimestre)
                                            <option value="{{ $trimestre }}" 
                                                    {{ request('trimestre') == $trimestre ? 'selected' : '' }}>
                                                {{ $trimestre }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="annee_scolaire" class="form-label fw-bold">Année scolaire</label>
                                <select name="annee_scolaire" id="annee_scolaire" class="form-select">
                                    <option value="">Toutes</option>
                                    @isset($annees)
                                        @foreach($annees as $annee)
                                            <option value="{{ $annee }}" 
                                                    {{ request('annee_scolaire') == $annee ? 'selected' : '' }}>
                                                {{ $annee }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="eleve_id" class="form-label fw-bold">Élève</label>
                                <select name="eleve_id" id="eleve_id" class="form-select">
                                    <option value="">Tous</option>
                                    @isset($eleves)
                                        @foreach($eleves as $eleve)
                                            <option value="{{ $eleve->id }}" 
                                                    {{ request('eleve_id') == $eleve->id ? 'selected' : '' }}>
                                                {{ $eleve->nom_complet ?? $eleve->nom ?? 'Élève' }}
                                                @if(isset($eleve->matricule))
                                                    ({{ $eleve->matricule }})
                                                @endif
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i> Filtrer
                                </button>
                                <a href="{{ route('notes.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-undo me-1"></i> Réinitialiser
                                </a>
                                <button type="button" class="btn btn-success float-end" onclick="exportCSV()">
                                    <i class="fas fa-file-csv me-1"></i> Exporter CSV
                                </button>
                                <button type="button" class="btn btn-danger float-end me-2" onclick="exportPDF()">
                                    <i class="fas fa-file-pdf me-1"></i> Exporter PDF
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Résumé des résultats -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <span class="badge bg-primary fs-6 p-2">
                        <i class="fas fa-list me-1"></i> 
                        @isset($notes)
                            {{ $notes->total() }} note(s) trouvée(s)
                        @else
                            0 note(s)
                        @endisset
                    </span>
                    @if(request('classe_id') || request('matiere_id') || request('trimestre') || request('annee_scolaire') || request('eleve_id'))
                        <span class="badge bg-warning text-dark fs-6 p-2 ms-2">
                            <i class="fas fa-filter me-1"></i> Filtres actifs
                        </span>
                    @endif
                </div>
                <div>
                    @isset($notes)
                        <span class="text-muted">
                            Page {{ $notes->currentPage() }} sur {{ $notes->lastPage() }}
                        </span>
                    @endisset
                </div>
            </div>

            <!-- Tableau des notes -->
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 30px;">#</th>
                                    <th>Élève</th>
                                    <th>Classe</th>
                                    <th>Matière</th>
                                    <th style="width: 120px;" class="text-center">Note</th>
                                    <th style="width: 90px;" class="text-center">Trimestre</th>
                                    <th style="width: 120px;">Année</th>
                                    <th>Appréciation</th>
                                    <th style="width: 160px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($notes)
                                    @forelse($notes as $note)
                                        <tr>
                                            <td>{{ $loop->iteration + ($notes->currentPage() - 1) * $notes->perPage() }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle me-2" style="background-color: {{ $note->eleve ? '#'.substr(md5($note->eleve->nom ?? ''), 0, 6) : '#6c757d' }};">
                                                        {{ $note->eleve ? strtoupper(substr($note->eleve->prenom ?? $note->eleve->nom ?? '', 0, 1)) : '?' }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">{{ $note->eleve->nom_complet ?? $note->eleve->nom ?? 'N/A' }}</div>
                                                        <small class="text-muted">Matricule: {{ $note->eleve->matricule ?? 'N/A' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($note->eleve && isset($note->eleve->classe))
                                                    <span class="badge bg-secondary">
                                                        {{ $note->eleve->classe->nom ?? 'N/A' }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{ $note->matiere->nom ?? 'N/A' }}</span>
                                                @if(isset($note->matiere) && isset($note->matiere->code))
                                                    <br><small class="text-muted">{{ $note->matiere->code }}</small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge 
                                                    @if($note->valeur >= 16) bg-success
                                                    @elseif($note->valeur >= 12) bg-primary
                                                    @elseif($note->valeur >= 10) bg-warning text-dark
                                                    @else bg-danger
                                                    @endif
                                                    fs-6 p-2" style="min-width: 60px;">
                                                    {{ number_format($note->valeur, 2, ',', ' ') }} / 20
                                                </span>
                                                @if(isset($note->coef) && $note->coef > 1)
                                                    <br><small class="text-muted">Coef: {{ $note->coef }}</small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info text-dark">
                                                    {{ $note->trimestre ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border">
                                                    {{ $note->annee_scolaire ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-truncate d-block" style="max-width: 200px;" title="{{ $note->appreciation ?? '' }}">
                                                    {{ $note->appreciation ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('notes.show', $note) }}" 
                                                       class="btn btn-info" 
                                                       title="Voir">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('notes.edit', $note) }}" 
                                                       class="btn btn-warning" 
                                                       title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-danger" 
                                                            title="Supprimer"
                                                            onclick="confirmDelete({{ $note->id }}, '{{ $note->eleve->nom_complet ?? $note->eleve->nom ?? 'N/A' }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                <!-- Formulaire de suppression caché -->
                                                <form id="delete-form-{{ $note->id }}" 
                                                      action="{{ route('notes.destroy', $note) }}" 
                                                      method="POST" 
                                                      style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">Aucune note trouvée</h5>
                                                    <p class="text-muted">
                                                        @if(request('classe_id') || request('matiere_id') || request('trimestre') || request('annee_scolaire'))
                                                            Aucune note ne correspond aux filtres sélectionnés.
                                                        @else
                                                            Commencez par ajouter votre première note.
                                                        @endif
                                                    </p>
                                                    <a href="{{ route('notes.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus-circle me-1"></i> Ajouter une note
                                                    </a>
                                                    @if(request('classe_id') || request('matiere_id') || request('trimestre') || request('annee_scolaire'))
                                                        <a href="{{ route('notes.index') }}" class="btn btn-secondary ms-2">
                                                            <i class="fas fa-undo me-1"></i> Réinitialiser les filtres
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-exclamation-circle fa-3x text-warning mb-3"></i>
                                                <h5 class="text-muted">Données non disponibles</h5>
                                                <p class="text-muted">Veuillez vérifier votre connexion à la base de données.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    @isset($notes)
                        <span class="text-muted">
                            Affichage de {{ $notes->firstItem() ?? 0 }} à {{ $notes->lastItem() ?? 0 }} sur {{ $notes->total() }} notes
                        </span>
                    @endisset
                </div>
                <div>
                    @isset($notes)
                        {{ $notes->appends(request()->query())->links() }}
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDelete(id, nom) {
        if (confirm(`Êtes-vous sûr de vouloir supprimer la note de ${nom} ? Cette action est irréversible.`)) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    }

    function exportCSV() {
        const params = new URLSearchParams(window.location.search);
        params.append('export', 'csv');
        window.location.href = `{{ route('notes.index') }}?${params.toString()}`;
    }

    function exportPDF() {
        const params = new URLSearchParams(window.location.search);
        params.append('export', 'pdf');
        window.location.href = `{{ route('notes.index') }}?${params.toString()}`;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Auto-submit sur changement de select
        const autoSubmitFields = ['classe_id', 'matiere_id', 'trimestre', 'annee_scolaire'];
        
        autoSubmitFields.forEach(function(fieldId) {
            const element = document.getElementById(fieldId);
            if (element) {
                element.addEventListener('change', function() {
                    document.getElementById('filterForm').submit();
                });
            }
        });

        // Délai pour la recherche par élève
        let timeout = null;
        const eleveSelect = document.getElementById('eleve_id');
        if (eleveSelect) {
            eleveSelect.addEventListener('change', function() {
                clearTimeout(timeout);
                timeout = setTimeout(function() {
                    document.getElementById('filterForm').submit();
                }, 300);
            });
        }

        // Mise en évidence des filtres actifs
        const activeFilters = document.querySelectorAll('.form-select');
        activeFilters.forEach(function(select) {
            if (select.value && select.value !== '') {
                select.style.borderColor = '#ffc107';
                select.style.borderWidth = '2px';
            }
        });

        // Raccourcis clavier
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === 'n') {
                e.preventDefault();
                window.location.href = '{{ route("notes.create") }}';
            }
            
            if (e.ctrlKey && e.key === 'f') {
                e.preventDefault();
                const firstFilter = document.querySelector('.form-select');
                if (firstFilter) {
                    firstFilter.focus();
                }
            }
            
            if (e.ctrlKey && e.key === 'r') {
                e.preventDefault();
                window.location.reload();
            }
        });
    });
</script>

<style>
    .avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 14px;
        flex-shrink: 0;
    }

    .table > :not(caption) > * > * {
        vertical-align: middle;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    .badge {
        font-weight: 500;
    }

    .badge.fs-6 {
        font-size: 0.95rem !important;
        padding: 6px 12px;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    .empty-state i {
        opacity: 0.5;
    }

    .btn-group-sm .btn {
        padding: 4px 8px;
        font-size: 12px;
    }

    .btn-group-sm .btn i {
        font-size: 12px;
    }

    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .pagination {
        margin-bottom: 0;
    }

    .pagination .page-link {
        color: #0d6efd;
        border-radius: 4px;
        margin: 0 2px;
    }

    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }

    .pagination .page-item.disabled .page-link {
        color: #6c757d;
    }

    tbody tr {
        animation: fadeInUp 0.3s ease-in-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 10px;
            align-items: stretch;
        }

        .d-flex.justify-content-between .d-flex {
            flex-wrap: wrap;
        }

        .btn-group-sm {
            flex-wrap: wrap;
            gap: 4px;
        }

        .btn-group-sm .btn {
            padding: 6px 10px;
        }

        .table-responsive {
            font-size: 14px;
        }

        .badge.fs-6 {
            font-size: 0.8rem !important;
            padding: 4px 8px;
        }

        .avatar-circle {
            width: 28px;
            height: 28px;
            font-size: 11px;
        }

        .card-body .row .col-md-2,
        .card-body .row .col-md-3 {
            margin-bottom: 10px;
        }

        .float-end {
            float: none !important;
            margin-top: 10px;
            margin-left: 0 !important;
        }

        .btn-success.float-end,
        .btn-danger.float-end {
            width: 100%;
            margin-left: 0 !important;
        }
    }

    @media print {
        .btn, .btn-group, .actions, .no-print {
            display: none !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }

        .table {
            font-size: 12px !important;
        }
    }
</style>
@endsection