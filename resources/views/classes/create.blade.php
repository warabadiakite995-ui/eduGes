<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GES EDU - Ajouter une classe</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f0fdf4; color: #1a202c; min-height: 100vh; display: flex; flex-direction: column; }
        .header { background: linear-gradient(135deg, #064e3b 0%, #059669 100%); color: white; padding: 1.5rem 2rem; }
        .header-content { max-width: 800px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 1.5rem; display: flex; align-items: center; gap: 12px; }
        .header h1 i { color: #a7f3d0; }
        .header-subtitle { font-size: 0.85rem; opacity: 0.85; }
        .header-back { background: rgba(255,255,255,0.15); padding: 0.5rem 1.2rem; border-radius: 30px; text-decoration: none; color: white; display: flex; align-items: center; gap: 8px; }
        .container { max-width: 800px; margin: 0 auto; padding: 2rem; flex: 1; }
        .form-card { background: white; border-radius: 16px; padding: 2rem; border: 1px solid #f3f4f6; }
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151; }
        .form-label span { color: #dc2626; }
        .form-control { width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 10px; background: #f9fafb; }
        .form-control:focus { outline: none; border-color: #059669; box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1); }
        .form-actions { display: flex; gap: 1rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f3f4f6; }
        .btn-primary { background: #059669; color: white; border: none; padding: 0.75rem 2rem; border-radius: 10px; font-weight: 600; cursor: pointer; }
        .btn-primary:hover { background: #047857; }
        .btn-secondary { background: #e5e7eb; color: #374151; border: none; padding: 0.75rem 2rem; border-radius: 10px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-secondary:hover { background: #d1d5db; }
        @media (max-width: 600px) { .form-actions { flex-direction: column; } .btn-primary, .btn-secondary { width: 100%; text-align: center; } }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div><h1><i class="fas fa-school"></i> Ajouter une classe</h1><div class="header-subtitle">Remplissez les informations</div></div>
            <a href="{{ route('classes.index') }}" class="header-back"><i class="fas fa-arrow-left"></i> Retour</a>
        </div>
    </header>

    <div class="container">
        <div class="form-card">
            <form action="{{ route('classes.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nom de la classe <span>*</span></label>
                    <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" placeholder="Ex: 6ème A" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Niveau</label>
                    <input type="text" name="niveau" class="form-control" value="{{ old('niveau') }}" placeholder="Ex: Primaire, Collège, Lycée">
                </div>
                <div class="form-group">
                    <label class="form-label">Année Scolaire</label>
                    <input type="text" name="annee_scolaire" class="form-control" value="{{ old('annee_scolaire') }}" placeholder="Ex: 2025-2026">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Enregistrer</button>
                    <a href="{{ route('classes.index') }}" class="btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>