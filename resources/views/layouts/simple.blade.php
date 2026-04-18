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
            <a class="navbar-brand fw-bold text-primary" href="{{ route('dashboard') }}">
                <i class="fas fa-clinic-medical"></i> Cabinet Médical
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        {{-- 1. واجهة المريض: حيدنا "Liste patients" --}}
                        @if(Auth::user()->role == 'patient')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('rendez-vous.create') }}">Prendre RDV</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('rendez-vous.index') }}">Mes RDV</a>
                            </li>
                        @endif
                        
                        {{-- 2. واجهة الطبيب: هنا فين زدت "Liste patients" --}}
                        @if(Auth::user()->role == 'medecin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('medecin.rendez-vous') }}">Mes consultations</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('medecin.patients.index') }}">Liste patients</a>
                            </li>
                        @endif
                        
                        {{-- 3. واجهة السكريتيرة والأدمن --}}
                        @if(Auth::user()->role == 'secretaire' || Auth::user()->role == 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('patients.create') }}">Ajouter patient</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('patients.index') }}">Liste patients</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('gestion-rdv.index') }}">Gestion RDV</a>
                            </li>
                        @endif
                        
                        @if(Auth::user()->role == 'admin')
                            <li class="nav-item">
                                <a class="nav-link text-danger" href="#"><i class="fas fa-user-shield"></i> Administration</a>
                            </li>
                        @endif
                        
                        <li class="nav-item ms-lg-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
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
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif
        
        @if(session('error') && session('error') != 'Vous n\'avez pas de dossier patient.')
            <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
        @endif
        
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>