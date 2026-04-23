<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet Médical | Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .feature-card {
            text-align: center;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            margin-bottom: 30px;
            background: white;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 20px;
        }

        .btn-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: bold;
            margin: 10px;
            border: none;
        }

        .btn-custom:hover {
            transform: scale(1.05);
            color: white;
        }

        .footer {
            background: #2d3748;
            color: white;
            padding: 30px 0;
            margin-top: 50px;
            text-align: center;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #667eea !important;
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-stethoscope"></i> Cabinet Médical
            </a>
            <div class="ms-auto">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-outline-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Connexion</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Inscription</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="container">
            <h1>Bienvenue au Cabinet Médical</h1>
            <p>Prenez rendez-vous en ligne, consultez vos médecins, et gérez votre santé facilement</p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-custom">
                    <i class="fas fa-calendar-plus"></i> Prendre rendez-vous
                </a>
            @endguest
        </div>
    </div>

    <!-- Features Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h4>Rendez-vous en ligne</h4>
                    <p>Prenez rendez-vous avec nos médecins facilement et rapidement 24h/24</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <h4>Dossiers médicaux</h4>
                    <p>Accédez à votre historique médical et à vos ordonnances en ligne</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4>Suivi statistique</h4>
                    <p>Suivez l'activité du cabinet avec des graphiques détaillés</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Doctors Section — ديناميكي من DB -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Nos médecins</h2>
        <div class="row justify-content-center">
            @forelse($medecins as $medecin)
                <div class="col-md-4 mb-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-user-md fa-3x mb-3" style="color: #667eea;"></i>
                            <h5 class="card-title">Dr. {{ $medecin->user->name }}</h5>
                            <p class="card-text text-muted">{{ $medecin->specialite }}</p>
                            <span class="badge bg-primary">Disponible</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted">
                    <p>Aucun médecin disponible pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="container text-center">
            <p>&copy; 2026 Cabinet Médical - Tous droits réservés</p>
            <p>
                <i class="fas fa-phone"></i> +212 5 22 45 67 89 &nbsp;|&nbsp;
                <i class="fas fa-envelope"></i> contact@cabinet-medical.ma &nbsp;|&nbsp;
                <i class="fas fa-map-marker-alt"></i> 123 Rue Hassan II, Casablanca
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
