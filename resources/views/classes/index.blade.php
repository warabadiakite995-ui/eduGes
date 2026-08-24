<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GES EDU - Classes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f0fdf4; color: #1a202c; display: flex; flex-direction: column; min-height: 100vh; }
        .header { background: linear-gradient(135deg, #064e3b 0%, #059669 100%); color: white; padding: 1.5rem 2rem; box-shadow: 0 4px 20px rgba(5, 150, 105, 0.3); }
        .header-content { max-width: 1400px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; }
        .header h1 { font-size: 1.5rem; font-weight: 700; display: flex; align-items: center; gap: 12px; }
        .header h1 i { color: #a7f3d0; }
        .header-subtitle { font-size: 0.85rem; opacity: 0.85; }
        .header-back { background: rgba(255,255,255,0.15); padding: 0.5rem 1.2rem; border-radius: 30px; text-decoration: none; color: white; display: flex; align-items: center; gap: 8px; }
        .header-back:hover { background: rgba(255,255,255,0.25); }
        .container { max-width: 1400px; margin: 0 auto; padding: 2rem; flex: 1; width: 100%; }
        .action-bar { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem; }
        .btn-primary { background: #059669; color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 10px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.3); }
        .btn-primary:hover { background: #047857; transform: translateY(-2px); }
        .table-card { background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        thead { background: #f9fafb; border-bottom: 2px solid #e5e7eb; }
        th { text-align: left; padding: 1rem 0.5rem; color: #6b7280; font-weight: 600; text-transform: uppercase; font-size: 0.75rem; }
        td { padding: 1rem 0.5rem; border-bottom: 1px solid #f3f4f6; color: #374151; }
        tr:hover { background: #f9fafb; }
        .badge-annee { background: #ecfdf5; color: #059669; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
        .action-btns { display: flex; gap: 8px; justify-content: flex-end; }
        .btn-icon { width: 32px; height: 32px; border-radius: 8px; border: none; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; text-decoration: none; transition: 0.2s; }
        .btn-icon:hover { transform: translateY(-2px); }
        .btn-edit { background: #fef3c7; color: #d97706; }
        .btn-edit:hover { background: #fde68a; }
        .btn-delete { background: #fee2e2; color: #dc2626; }
        .btn-delete:hover { background: #fecaca; }
        @media (max-width: 768px) { .action-bar { flex-direction: column; align-items: stretch; } .btn-primary { width: 100%; justify-content: center; } }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div>
                <h1><i class="fas fa-school"></i> Gestion des Classes</h1>
                <div class="header-subtitle">Liste des classes et niveaux</div>
            </div>
            <a href="{{ route('dashboard') }}" class="header-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
        </div>
    </header>

    <div class="container">
        <div class="action-bar">
            <a href="{{ route('classes.create') }}" class="btn-primary"><i class="fas fa-plus-circle"></i> Ajouter une classe</a>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom de la classe</th>
                        <th>Niveau</th>
                        <th>Année Scolaire</th>
                        <th>Date de création</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $classe)
                    <tr>
                        <td style="color: #9ca3af;">{{ $classe->id }}</td>
                        <td><strong>{{ $classe->nom }}</strong></td>
                        <td>{{ $classe->niveau ?? '-' }}</td>
                        <td><span class="badge-annee">{{ $classe->annee_scolaire ?? '-' }}</span></td>
                        <td style="color: #6b7280; font-size: 0.85rem;">{{ $classe->created_at->format('d/m/Y') }}</td>
                        <td style="text-align: right;">
                            <div class="action-btns">
                                <a href="{{ route('classes.edit', $classe) }}" class="btn-icon btn-edit" title="Modifier">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('classes.destroy', $classe) }}" method="POST" onsubmit="return confirm('Supprimer cette classe ?');" style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon btn-delete" title="Supprimer"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align: center; padding: 3rem 0; color: #9ca3af;">Aucune classe enregistrée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>