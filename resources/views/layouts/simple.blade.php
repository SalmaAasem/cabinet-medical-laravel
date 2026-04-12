<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cabinet Médical</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="fas fa-stethoscope text-primary"></i> Cabinet Médical
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if(Auth::user()->role == 'patient')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('rendez-vous.create') }}">
                                <i class="fas fa-calendar-plus"></i> Prendre RDV
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('rendez-vous.index') }}">
                                <i class="fas fa-list"></i> Mes RDV
                            </a>
                        </li>
                        @endif
                        
                        @if(Auth::user()->role == 'medecin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('medecin.rendez-vous') }}">
                                <i class="fas fa-stethoscope"></i> Mes consultations
                            </a>
                        </li>
                        @endif
                        
                        @if(Auth::user()->role == 'secretaire' || Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patients.create') }}">
                                <i class="fas fa-user-plus"></i> Ajouter patient
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('patients.index') }}">
                                <i class="fas fa-users"></i> Liste patients
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('gestion-rdv.index') }}">
                                <i class="fas fa-calendar-alt"></i> Gestion RDV
                            </a>
                        </li>
                        @endif
                        
                        @if(Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cog"></i> Administration
                            </a>
                        </li>
                        @endif
                        
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link" style="border: none; background: none;">
                                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                                </button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error') && session('error') != 'Vous n\'avez pas de dossier patient.')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>