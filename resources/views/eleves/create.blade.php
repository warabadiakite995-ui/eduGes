{{-- resources/views/eleves/create.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GES EDU - Ajouter un élève</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f0fdf4;
            color: #1a202c;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: linear-gradient(135deg, #064e3b 0%, #059669 100%);
            color: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 20px rgba(5, 150, 105, 0.3);
        }
        .header-content {
            max-width: 800px;
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
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .header-back:hover { background: rgba(255,255,255,0.25); }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            flex: 1;
            width: 100%;
        }

        .form-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #f3f4f6;
        }

        .form-group { margin-bottom: 1.5rem; }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: #374151;
        }
        .form-label span { color: #dc2626; }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 1rem;
            font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #f9fafb;
        }
        .form-control:focus {
            outline: none;
            border-color: #059669;
            background: white;
            box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.1);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            border-top: 1px solid #f3f4f6;
            padding-top: 1.5rem;
        }

        .btn-primary {
            background: #059669;
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s, transform 0.1s;
            box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.3);
        }
        .btn-primary:hover { background: #047857; transform: translateY(-2px); }

        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }
        .btn-secondary:hover { background: #d1d5db; }

        @media (max-width: 600px) {
            .header { padding: 1rem; }
            .container { padding: 1rem; }
            .form-actions { flex-direction: column; }
            .btn-primary, .btn-secondary { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

    <header class="header">
        <div class="header-content">
            <div>
                <h1>
                    <i class="fas fa-user-graduate"></i>
                    Ajouter un élève
                </h1>
                <div class="header-subtitle">Remplissez les informations ci-dessous</div>
            </div>
            <a href="{{ route('eleves.index') }}" class="header-back">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </header>

    <div class="container">
        <div class="form-card">
            <form action="{{ route('eleves.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="nom">Nom <span>*</span></label>
                    <input type="text" id="nom" name="nom" class="form-control" value="{{ old('nom') }}" required>
                    @error('nom') <div style="color: #dc2626; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="prenom">Prénom <span>*</span></label>
                    <input type="text" id="prenom" name="prenom" class="form-control" value="{{ old('prenom') }}" required>
                    @error('prenom') <div style="color: #dc2626; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="date_naissance">Date de naissance <span>*</span></label>
                    <input type="date" id="date_naissance" name="date_naissance" class="form-control" value="{{ old('date_naissance') }}" required>
                    @error('date_naissance') <div style="color: #dc2626; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="classe_id">Classe <span>*</span></label>
                    <select id="classe_id" name="classe_id" class="form-control" required>
                        <option value="">Sélectionnez une classe</option>
                        @foreach(\App\Models\Classe::all() as $classe)
                            <option value="{{ $classe->id }}" {{ old('classe_id') == $classe->id ? 'selected' : '' }}>
                                {{ $classe->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('classe_id') <div style="color: #dc2626; font-size: 0.85rem; margin-top: 0.25rem;">{{ $message }}</div> @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                    <a href="{{ route('eleves.index') }}" class="btn-secondary">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>