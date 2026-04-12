<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cabinet Médical</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Cabinet Médical</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if(Auth::user()->role == 'patient')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('rendez-vous.create') }}">Prendre RDV</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('rendez-vous.index') }}">Mes RDV</a>
                        </li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('patients.index') }}">Liste patients</a>
</li>
                        @endif
                        
                        @if(Auth::user()->role == 'medecin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('medecin.rendez-vous') }}">Mes consultations</a>
                        </li>
                        @endif
                        
                        @if(Auth::user()->role == 'secretaire' || Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patients.create') }}">Ajouter patient</a>
                        </li>
                      <li class="nav-item">
    <a class="nav-link" href="{{ route('gestion-rdv.index') }}">Gestion RDV</a>
</li>
                        @endif
                        
                        @if(Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="#">Administration</a>
                        </li>
                        @endif
                        
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Déconnexion</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @if(session('error') && session('error') != 'Vous n\'avez pas de dossier patient.')
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>