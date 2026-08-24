<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GES EDU - Bulletins</title>
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
        .badge-eleve { background: #ecfdf5; color: #059669; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
        .badge-trimestre { background: #eff6ff; color: #2563eb; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
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
                <h1><i class="fas fa-flag-checkered"></i> Gestion des Bulletins</h1>
                <div class="header-subtitle">Liste des relevés de notes</div>
            </div>
            <a href="{{ route('dashboard') }}" class="header-back"><i class="fas fa-arrow-left"></i> Dashboard</a>
        </div>
    </header>

    <div class="container">
        <div class="action-bar">
            <a href="{{ route('bulletins.create') }}" class="btn-primary"><i class="fas fa-plus-circle"></i> Ajouter un bulletin</a>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Élève</th>
                        <th>Trimestre</th>
                        <th>Moyenne</th>
                        <th>Rang</th>
                        <th style="text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bulletins as $bulletin)
                    <tr>
                        <td style="color: #9ca3af;">{{ $bulletin->id }}</td>
                        <td>
                            <span class="badge-eleve">
                                {{ $bulletin->eleve->prenom ?? 'Inconnu' }} {{ $bulletin->eleve->nom ?? '' }}
                            </span>
                        </td>
                        <td><span class="badge-trimestre">Trimestre {{ $bulletin->trimestre }}</span></td>
                        <td><strong>{{ number_format($bulletin->moyenne_generale, 2) }}</strong> / 20</td>
                        <td>{{ $bulletin->rang }}</td>
                        <td style="text-align: right;">
                            <div class="action-btns">
                                <a href="{{ route('bulletins.edit', $bulletin) }}" class="btn-icon btn-edit" title="Modifier">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form action="{{ route('bulletins.destroy', $bulletin) }}" method="POST" onsubmit="return confirm('Supprimer ce bulletin ?');" style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon btn-delete" title="Supprimer"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align: center; padding: 3rem 0; color: #9ca3af;">Aucun bulletin enregistré.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>