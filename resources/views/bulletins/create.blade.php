<!DOCTYPE html>
<html lang="fr">
<head> <!-- Même CSS que les autres formulaires --> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>/* Même CSS que le formulaire "Ajouter un élève" précédent */ * { margin:0; padding:0; box-sizing:border-box; } body { font-family: 'Inter', sans-serif; background: #f0fdf4; color: #1a202c; min-height: 100vh; display: flex; flex-direction: column; } .header { background: linear-gradient(135deg, #064e3b 0%, #059669 100%); color: white; padding: 1.5rem 2rem; } .header-content { max-width: 800px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; } .header h1 { font-size: 1.5rem; display: flex; align-items: center; gap: 12px; } .header h1 i { color: #a7f3d0; } .header-subtitle { font-size: 0.85rem; opacity: 0.85; } .header-back { background: rgba(255,255,255,0.15); padding: 0.5rem 1.2rem; border-radius: 30px; text-decoration: none; color: white; display: flex; align-items: center; gap: 8px; } .container { max-width: 800px; margin: 0 auto; padding: 2rem; flex: 1; } .form-card { background: white; border-radius: 16px; padding: 2rem; border: 1px solid #f3f4f6; } .form-group { margin-bottom: 1.5rem; } .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151; } .form-control { width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 10px; background: #f9fafb; } .form-control:focus { outline: none; border-color: #059669; box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1); } select.form-control { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 1rem center; background-size: 1rem; } .form-actions { display: flex; gap: 1rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f3f4f6; } .btn-primary { background: #059669; color: white; border: none; padding: 0.75rem 2rem; border-radius: 10px; font-weight: 600; cursor: pointer; } .btn-primary:hover { background: #047857; } .btn-secondary { background: #e5e7eb; color: #374151; border: none; padding: 0.75rem 2rem; border-radius: 10px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-block; } .btn-secondary:hover { background: #d1d5db; } @media (max-width: 600px) { .form-actions { flex-direction: column; } .btn-primary, .btn-secondary { width: 100%; text-align: center; } }</style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div><h1><i class="fas fa-flag-checkered"></i> Ajouter un bulletin</h1><div class="header-subtitle">Remplissez les informations</div></div>
            <a href="{{ route('bulletins.index') }}" class="header-back"><i class="fas fa-arrow-left"></i> Retour</a>
        </div>
    </header>

    <div class="container">
        <div class="form-card">
            <form action="{{ route('bulletins.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Élève <span style="color:#dc2626;">*</span></label>
                    <select name="eleve_id" class="form-control" required>
                        <option value="">Sélectionnez un élève</option>
                        @foreach($eleves as $eleve)
                            <option value="{{ $eleve->id }}" {{ old('eleve_id') == $eleve->id ? 'selected' : '' }}>
                                {{ $eleve->prenom }} {{ $eleve->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Trimestre <span style="color:#dc2626;">*</span></label>
                    <select name="trimestre" class="form-control" required>
                        <option value="">Sélectionnez</option>
                        <option value="1" {{ old('trimestre') == '1' ? 'selected' : '' }}>1</option>
                        <option value="2" {{ old('trimestre') == '2' ? 'selected' : '' }}>2</option>
                        <option value="3" {{ old('trimestre') == '3' ? 'selected' : '' }}>3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Moyenne Générale <span style="color:#dc2626;">*</span></label>
                    <input type="number" step="0.01" name="moyenne_generale" class="form-control" value="{{ old('moyenne_generale') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Rang <span style="color:#dc2626;">*</span></label>
                    <input type="number" name="rang" class="form-control" value="{{ old('rang') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Appréciation</label>
                    <textarea name="appreciation" class="form-control" rows="2">{{ old('appreciation') }}</textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Enregistrer</button>
                    <a href="{{ route('bulletins.index') }}" class="btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>