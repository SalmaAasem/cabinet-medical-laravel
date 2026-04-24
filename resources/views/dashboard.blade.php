@extends('layouts.simple')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                {{-- Header Card --}}
                <div class="card shadow-lg border-0 rounded-4 mb-4"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body p-4 text-white">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 class="fw-bold mb-2">
                                    <i class="fas fa-stethoscope me-2"></i>
                                    Bienvenue, {{ Auth::user()->name }} !
                                </h2>
                                <p class="mb-0 opacity-75">
                                    @if (Auth::user()->role == 'patient')
                                        Vous êtes connecté en tant que patient.
                                    @elseif(Auth::user()->role == 'medecin')
                                        Vous êtes connecté en tant que médecin.
                                    @elseif(Auth::user()->role == 'secretaire')
                                        Vous êtes connecté en tant que secrétaire.
                                    @elseif(Auth::user()->role == 'admin')
                                        Vous êtes connecté en tant qu'administrateur.
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4 text-center">
                                <i class="fas fa-user-md fa-4x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics for Staff only --}}
        @if (Auth::user()->role != 'patient')
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                        <div class="card-body">
                            <i class="fas fa-calendar-check fa-3x text-primary mb-2"></i>
                            <h3 class="fw-bold mb-0">{{ $rdvAujourdhui ?? 0 }}</h3>
                            <p class="text-muted mb-0 small">Rendez-vous aujourd'hui</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                        <div class="card-body">
                            <i class="fas fa-users fa-3x text-primary mb-2" style="color: #667eea !important;"></i>
                            <h3 class="fw-bold mb-0">{{ $totalPatients ?? 0 }}</h3>
                            <p class="text-muted mb-0 small">Patients total</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                        <div class="card-body">
                            <i class="fas fa-user-md fa-3x text-info mb-2"></i>
                            <h3 class="fw-bold mb-0">{{ $totalMedecins ?? 0 }}</h3>
                            <p class="text-muted mb-0 small">Médecins</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                        <div class="card-body">
                            <i class="fas fa-chart-line fa-3x text-warning mb-2"></i>
                            <h3 class="fw-bold mb-0">{{ $consultationsMois ?? 0 }}</h3>
                            <p class="text-muted mb-0 small">Consultations ce mois</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Quick Actions --}}
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <h4 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-bolt text-primary me-2"></i> Actions rapides
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">

     
                            
                            {{-- Medecin Actions --}}
@if (Auth::user()->role == 'medecin')
    <div class="col-md-4">
        <a href="{{ route('medecin.rendez-vous') }}"
            class="btn btn-primary w-100 py-3 rounded-3 shadow-sm"
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
            <i class="fas fa-calendar-check me-2"></i> Mes consultations
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('medecin.patients.index') }}"
            class="btn btn-outline-primary w-100 py-3 rounded-3 shadow-sm">
            <i class="fas fa-file-medical me-2"></i> Liste des Patients
        </a>
    </div>
    
    <div class="col-md-4">
        <a href="{{ route('medecin.planning.index') }}"
            class="btn btn-primary w-100 py-3 rounded-3 shadow-sm"
            style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border: none;">
            <i class="fas fa-clock me-2"></i> Mon Planning
        </a>
    </div>
@endif
                            {{-- Patient Actions (Modified to Blue/Purple) --}}
                            @if (Auth::user()->role == 'patient')
                                <div class="col-md-6">
                                    <a href="{{ route('patient.my_history') }}"
                                        class="btn btn-primary w-100 py-3 rounded-3 shadow-sm"
                                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                        <i class="fas fa-history me-2"></i> Mon Historique Médical
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('rendez-vous.index') }}"
                                        class="btn btn-outline-primary w-100 py-3 rounded-3 shadow-sm">
                                        <i class="fas fa-calendar-alt me-2"></i> Mes Rendez-vous
                                    </a>
                                </div>
                            @endif

                            {{-- Secretaire / Admin Actions --}}
                            @if (Auth::user()->role == 'secretaire' || Auth::user()->role == 'admin')
                                <div class="col-md-4">
                                    <a href="{{ route('patients.create') }}"
                                        class="btn btn-primary w-100 py-3 rounded-3 shadow-sm"
                                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                        <i class="fas fa-user-plus me-2"></i> Ajouter un patient
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('patients.index') }}"
                                        class="btn btn-primary w-100 py-3 rounded-3 shadow-sm"
                                        style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border: none;">
                                        <i class="fas fa-list me-2"></i> Liste des Patients
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('gestion-rdv.index') }}"
                                        class="btn btn-outline-primary w-100 py-3 rounded-3 shadow-sm">
                                        <i class="fas fa-calendar-alt me-2"></i> Gérer les rendez-vous
                                    </a>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <h4 class="mb-0 fw-bold">
                            <i class="fas fa-history text-primary me-2"></i> Activité récente
                        </h4>
                    </div>
                    <div class="card-body p-4 text-center text-muted">
                        <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                        <p class="mb-0">Aucune activité récente pour le moment.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .1) !important;
        }

        .btn {
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }
    </style>
@endsection
