{{-- resources/views/eleves/index.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GES EDU - Gestion des Élèves</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* --- RESET & CONFIGURATION --- */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f0fdf4; /* Fond très clair légèrement vert */
            color: #1a202c;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* --- HEADER --- */
        .header {
            background: linear-gradient(135deg, #064e3b 0%, #059669 100%);
            color: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 20px rgba(5, 150, 105, 0.3);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header h1 i { color: #a7f3d0; }
        .header-subtitle { font-size: 0.85rem; opacity: 0.85; margin-top: 0.25rem; }
        
        .header-back {
            background: rgba(255,255,255,0.15);
            padding: 0.5rem 1.2rem;
            border-radius: 30px;
            text-decoration: none;
            color: white;
            font-size: 0.85rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .header-back:hover { background: rgba(255,255,255,0.25); }

        /* --- LAYOUT PRINCIPAL --- */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            flex: 1;
            width: 100%;
        }

        /* --- BARRE D'ACTIONS (Ajout + Recherche) --- */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background: #059669;
            color: white;
            border: none;
            padding: 0.7rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s, transform 0.1s;
            box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.3);
        }
        .btn-primary:hover { background: #047857; transform: translateY(-2px); }
        .btn-primary:active { transform: translateY(0); }

        /* Barre de recherche */
        .search-wrapper {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 10px;
            padding: 0.4rem 0.4rem 0.4rem 1rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .search-wrapper:focus-within {
            border-color: #059669;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
        }
        .search-wrapper i { color: #9ca3af; }
        .search-wrapper input {
            border: none;
            padding: 0.5rem;
            outline: none;
            font-size: 0.9rem;
            color: #1f2937;
            width: 250px;
            font-family: inherit;
        }
        .search-wrapper button {
            background: #059669;
            color: white;
            border: none;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }
        .search-wrapper button:hover { background: #047857; }

        /* --- TABLEAU (Carte blanche) --- */
        .table-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #f3f4f6;
            overflow-x: auto; /* Empêche le débordement horizontal */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
        }

        thead {
            background: #f9fafb;
            border-bottom: 2px solid #e5e7eb;
        }

        th {
            text-align: left;
            padding: 1rem 0.5rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        td {
            padding: 1rem 0.5rem;
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
            vertical-align: middle;
        }

        tr:last-child td { border-bottom: none; }
        tr:hover { background: #f9fafb; }

        /* Badge pour la Classe */
        .badge-classe {
            background: #ecfdf5;
            color: #059669;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }

        /* Boutons d'action (Voir, Modifier, Supprimer) */
        .action-btns {
            display: flex;
            gap: 8px;
        }
        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-icon:hover { transform: translateY(-2px); }
        
        .btn-view { background: #eff6ff; color: #2563eb; }
        .btn-view:hover { background: #dbeafe; }
        
        .btn-edit { background: #fef3c7; color: #d97706; }
        .btn-edit:hover { background: #fde68a; }
        
        .btn-delete { background: #fee2e2; color: #dc2626; }
        .btn-delete:hover { background: #fecaca; }

        /* --- RESPONSIVE (Mobile) --- */
        @media (max-width: 768px) {
            .header { padding: 1rem; }
            .header h1 { font-size: 1.2rem; }
            .action-bar { flex-direction: column; align-items: stretch; }
            .search-wrapper { width: 100%; }
            .search-wrapper input { width: 100%; flex: 1; }
            .btn-primary { width: 100%; justify-content: center; }
            .table-card { padding: 1rem; }
            /* Sur très petits écrans, on peut cacher certaines colonnes */
            th:nth-child(3), td:nth-child(3) { display: none; } /* Cache la date de naissance */
            th:nth-child(4), td:nth-child(4) { display: none; } /* Cache la date d'inscription */
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header class="header">
        <div class="header-content">
            <div>
                <h1>
                    <i class="fas fa-user-graduate"></i>
                    Gestion des Élèves
                </h1>
                <div class="header-subtitle">Liste complète des apprenants</div>
            </div>
            <a href="{{ route('dashboard') }}" class="header-back">
                <i class="fas fa-arrow-left"></i> Retour au Dashboard
            </a>
        </div>
    </header>

    <div class="container">
        
        <!-- Actions -->
        <div class="action-bar">
            <a href="{{ route('eleves.create') }}" class="btn-primary">
                <i class="fas fa-plus-circle"></i> Ajouter un élève
            </a>

            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Rechercher un élève...">
                <button>Rechercher</button>
            </div>
        </div>

        <!-- Tableau -->
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th style="width: 20px;">#</th>
                        <th>Nom & Prénom</th>
                        <th>Date de naissance</th>
                        <th>Classe</th>
                        <th>Date d'inscription</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Boucle pour afficher les vrais élèves --}}
                    @forelse(\App\Models\Eleve::with('classe')->latest()->get() as $eleve)
                    <tr>
                        <td style="color: #9ca3af; font-weight: 600;">{{ $eleve->id }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 35px; height: 35px; background: #ecfdf5; color: #059669; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem;">
                                    {{ substr($eleve->prenom, 0, 1) }}{{ substr($eleve->nom, 0, 1) }}
                                </div>
                                <div>
                                    <div style="font-weight: 600;">{{ $eleve->prenom }} {{ $eleve->nom }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($eleve->date_naissance)->format('d/m/Y') }}</td>
                        <td>
                            @if($eleve->classe)
                                <span class="badge-classe">{{ $eleve->classe->nom }}</span>
                            @else
                                <span style="color: #9ca3af; font-size: 0.8rem;">Non assigné</span>
                            @endif
                        </td>
                        <td style="color: #6b7280; font-size: 0.85rem;">
                            {{ $eleve->created_at->format('d/m/Y') }}
                        </td>
                        <td style="text-align: right;">
                            <div class="action-btns" style="justify-content: flex-end;">
                                <a href="#" class="btn-icon btn-view" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('eleves.edit', $eleve->id) }}" class="btn-icon btn-edit" title="Modifier">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('eleves.destroy', $eleve->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet élève ?');" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon btn-delete" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 3rem 0; color: #9ca3af;">
                            <i class="fas fa-user-slash" style="font-size: 2rem; display: block; margin-bottom: 0.5rem;"></i>
                            Aucun élève n'a été enregistré pour le moment.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>