{{-- resources/views/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GES EDU - Tableau de bord</title>
    
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
            background: linear-gradient(135deg, #064e3b 0%, #059669 100%); /* Dégradé Vert Profond */
            color: white;
            padding: 2rem 2rem 1.5rem;
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
            font-size: 1.8rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header h1 i {
            color: #a7f3d0;
        }

        .header-subtitle {
            font-size: 0.95rem;
            opacity: 0.85;
            margin-top: 0.25rem;
            font-weight: 400;
        }

        .header-date {
            background: rgba(255,255,255,0.15);
            padding: 0.5rem 1.2rem;
            border-radius: 30px;
            font-size: 0.85rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* --- LAYOUT PRINCIPAL --- */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
            flex: 1;
        }

        /* --- STATISTIQUES (Grille) --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-left: 4px solid #059669; /* Liseré vert */
            display: flex;
            align-items: center;
            gap: 1rem;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px -8px rgba(5, 150, 105, 0.2);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .stat-icon.blue { background: #eff6ff; color: #2563eb; }
        .stat-icon.green { background: #ecfdf5; color: #059669; }
        .stat-icon.purple { background: #f5f3ff; color: #7c3aed; }
        .stat-icon.orange { background: #fff7ed; color: #ea580c; }
        .stat-icon.pink { background: #fdf2f8; color: #db2777; }
        .stat-icon.teal { background: #f0fdfa; color: #0d9488; }

        .stat-info h3 {
            font-size: 1.6rem;
            font-weight: 700;
            line-height: 1.2;
            color: #111827;
        }

        .stat-info p {
            font-size: 0.8rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* --- SECTION PRINCIPALE (Modules + Activités) --- */
        .main-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2.5rem;
        }

        @media (max-width: 992px) {
            .main-grid { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #f3f4f6;
            overflow: hidden;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .card-header h2 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-header h2 i { color: #059669; }

        .card-header a {
            font-size: 0.85rem;
            color: #059669;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .card-header a:hover { color: #047857; text-decoration: underline; }

        /* --- MODULES (Grille) --- */
        .modules-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        @media (max-width: 600px) {
            .modules-grid { grid-template-columns: 1fr; }
        }

        .module-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.8rem 1rem;
            background: #f9fafb;
            border-radius: 10px;
            text-decoration: none;
            color: #374151;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .module-item:hover {
            background: #ecfdf5; /* Vert très clair au survol */
            border-color: #a7f3d0;
            transform: translateX(4px);
        }

        .module-item i {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .mod-icon-blue { background: #eff6ff; color: #2563eb; }
        .mod-icon-green { background: #ecfdf5; color: #059669; }
        .mod-icon-purple { background: #f5f3ff; color: #7c3aed; }
        .mod-icon-orange { background: #fff7ed; color: #ea580c; }
        .mod-icon-pink { background: #fdf2f8; color: #db2777; }
        .mod-icon-teal { background: #f0fdfa; color: #0d9488; }

        .module-item span { font-weight: 500; font-size: 0.9rem; }
        .module-item small {
            margin-left: auto;
            background: #e5e7eb;
            padding: 0.15rem 0.6rem;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 600;
            color: #4b5563;
        }

        /* --- ACTIVITÉS RÉCENTES (Liste) --- */
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 0.5rem;
            border-radius: 8px;
            transition: background 0.2s;
        }
        .activity-item:hover { background: #f9fafb; }

        .activity-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .activity-dot.green { background: #10b981; box-shadow: 0 0 0 2px #d1fae5; }
        .activity-dot.blue { background: #3b82f6; box-shadow: 0 0 0 2px #dbeafe; }
        .activity-dot.orange { background: #f59e0b; box-shadow: 0 0 0 2px #fef3c7; }
        .activity-dot.purple { background: #8b5cf6; box-shadow: 0 0 0 2px #ede9fe; }
        .activity-dot.teal { background: #14b8a6; box-shadow: 0 0 0 2px #ccfbf1; }

        .activity-text { font-size: 0.9rem; color: #4b5563; flex: 1; }
        .activity-text strong { color: #1f2937; font-weight: 600; }
        .activity-time {
            font-size: 0.75rem;
            color: #9ca3af;
            white-space: nowrap;
            font-weight: 500;
        }

        /* --- FOOTER --- */
        .footer {
            text-align: center;
            padding: 1.5rem;
            color: #9ca3af;
            font-size: 0.85rem;
            border-top: 1px solid #e5e7eb;
            background: white;
            margin-top: auto;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 768px) {
            .header { padding: 1.2rem 1rem; }
            .header h1 { font-size: 1.3rem; }
            .header-content { flex-direction: column; align-items: flex-start; }
            .header-date { align-self: flex-start; margin-top: 0.5rem; }
            .container { padding: 1rem; }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header class="header">
        <div class="header-content">
            <div>
                <h1>
                    <i class="fas fa-graduation-cap"></i>
                    GES EDU
                </h1>
                <div class="header-subtitle">Portail de gestion éducative</div>
            </div>
            <div class="header-date">
                <i class="far fa-calendar-alt"></i>
                {{ now()->translatedFormat('l d F Y') }}
            </div>
        </div>
    </header>

    <div class="container">

        <!-- STATISTIQUES -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="fas fa-user-graduate"></i></div>
                <div class="stat-info">
                    <h3>{{ \App\Models\Eleve::count() }}</h3>
                    <p>Élèves inscrits</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="stat-info">
                    <h3>{{ \App\Models\Professeur::count() }}</h3>
                    <p>Enseignants</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple"><i class="fas fa-school"></i></div>
                <div class="stat-info">
                    <h3>{{ \App\Models\Classe::count() }}</h3>
                    <p>Classes actives</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange"><i class="fas fa-book-open"></i></div>
                <div class="stat-info">
                    <h3>{{ \App\Models\Matiere::count() }}</h3>
                    <p>Matières</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon pink"><i class="fas fa-file-signature"></i></div>
                <div class="stat-info">
                    <h3>{{ \App\Models\Note::count() }}</h3>
                    <p>Notes saisies</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon teal"><i class="fas fa-flag-checkered"></i></div>
                <div class="stat-info">
                    <h3>{{ \App\Models\Bulletin::count() }}</h3>
                    <p>Bulletins générés</p>
                </div>
            </div>
        </div>

        <!-- GRID PRINCIPAL -->
        <div class="main-grid">

            <!-- MODULES -->
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-th-large"></i> Navigation Rapide</h2>
                    <a href="#">Tout voir <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="modules-grid">
                    <a href="{{ route('eleves.index') }}" class="module-item">
                        <i class="fas fa-user-graduate mod-icon-blue"></i>
                        <span>Élèves</span>
                        <small>{{ \App\Models\Eleve::count() }}</small>
                    </a>
                    <a href="{{ route('professeurs.index') }}" class="module-item">
                        <i class="fas fa-chalkboard-teacher mod-icon-green"></i>
                        <span>Professeurs</span>
                        <small>{{ \App\Models\Professeur::count() }}</small>
                    </a>
                    <a href="{{ route('classes.index') }}" class="module-item">
                        <i class="fas fa-school mod-icon-purple"></i>
                        <span>Classes</span>
                        <small>{{ \App\Models\Classe::count() }}</small>
                    </a>
                    <a href="{{ route('matieres.index') }}" class="module-item">
                        <i class="fas fa-book-open mod-icon-orange"></i>
                        <span>Matières</span>
                        <small>{{ \App\Models\Matiere::count() }}</small>
                    </a>
                    <a href="{{ route('notes.index') }}" class="module-item">
                        <i class="fas fa-file-signature mod-icon-pink"></i>
                        <span>Notes</span>
                        <small>{{ \App\Models\Note::count() }}</small>
                    </a>
                    <a href="{{ route('bulletins.index') }}" class="module-item">
                        <i class="fas fa-flag-checkered mod-icon-teal"></i>
                        <span>Bulletins</span>
                        <small>{{ \App\Models\Bulletin::count() }}</small>
                    </a>
                </div>
            </div>

            <!-- ACTIVITÉS RÉCENTES -->
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-bolt"></i> Activités</h2>
                    <a href="#">Voir l'historique <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="activity-list">
                    
                    {{-- Exemple d'activités dynamiques (affichage des derniers élèves ajoutés) --}}
                    @foreach(\App\Models\Eleve::latest()->take(3)->get() as $eleve)
                    <div class="activity-item">
                        <span class="activity-dot blue"></span>
                        <span class="activity-text">
                            <strong>{{ $eleve->prenom }} {{ $eleve->nom }}</strong> a rejoint la {{ $eleve->classe->nom ?? 'classe' }}
                        </span>
                        <span class="activity-time">{{ $eleve->created_at->diffForHumans() }}</span>
                    </div>
                    @endforeach

                    @foreach(\App\Models\Professeur::latest()->take(2)->get() as $prof)
                    <div class="activity-item">
                        <span class="activity-dot green"></span>
                        <span class="activity-text">
                            <strong>{{ $prof->prenom }} {{ $prof->nom }}</strong> ({{ $prof->specialite }}) a rejoint l'équipe
                        </span>
                        <span class="activity-time">{{ $prof->created_at->diffForHumans() }}</span>
                    </div>
                    @endforeach

                    @if(\App\Models\Eleve::count() == 0 && \App\Models\Professeur::count() == 0)
                        <div style="text-align: center; padding: 2rem 0; color: #9ca3af;">
                            <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 0.5rem; display:block;"></i>
                            Aucune activité récente à afficher.
                        </div>
                    @endif

                </div>
            </div>

        </div>

    </div>

    <!-- FOOTER -->
    <div class="footer">
        <i class="far fa-copyright"></i> {{ now()->year }} GES EDU — Tous droits réservés
    </div>

</body>
</html>