@extends('layouts.simple')

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-4 mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-2">
                                <i class="fas fa-calendar-alt me-2"></i> 
                                Mes rendez-vous
                            </h2>
                            <p class="mb-0 opacity-75">
                                Consultez l'historique de vos rendez-vous médicaux
                            </p>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-calendar-check fa-4x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                <div class="card-body">
                    <i class="fas fa-clock fa-3x text-warning mb-2"></i>
                    <h3 class="fw-bold mb-0">{{ $rendezVous->where('statut', 'en_attente')->count() }}</h3>
                    <p class="text-muted mb-0">En attente</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-3x text-success mb-2"></i>
                    <h3 class="fw-bold mb-0">{{ $rendezVous->where('statut', 'confirme')->count() }}</h3>
                    <p class="text-muted mb-0">Confirmés</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                <div class="card-body">
                    <i class="fas fa-times-circle fa-3x text-danger mb-2"></i>
                    <h3 class="fw-bold mb-0">{{ $rendezVous->where('statut', 'annule')->count() }}</h3>
                    <p class="text-muted mb-0">Annulés</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                <div class="card-body">
                    <i class="fas fa-flag-checkered fa-3x text-info mb-2"></i>
                    <h3 class="fw-bold mb-0">{{ $rendezVous->where('statut', 'termine')->count() }}</h3>
                    <p class="text-muted mb-0">Terminés</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des rendez-vous -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <h4 class="mb-0 fw-bold">
                <i class="fas fa-list me-2 text-primary"></i> Liste de mes rendez-vous
            </h4>
        </div>
        <div class="card-body p-4">
            @if($rendezVous->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fas fa-calendar-times fa-4x mb-3 opacity-25"></i>
                    <p class="mb-0">Aucun rendez-vous pour le moment.</p>
                    <a href="{{ route('rendez-vous.create') }}" class="btn btn-primary mt-3 rounded-3">
                        <i class="fas fa-calendar-plus me-2"></i> Prendre un rendez-vous
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-user-md me-1"></i> Médecin</th>
                                <th><i class="fas fa-calendar me-1"></i> Date et heure</th>
                                <th><i class="fas fa-stethoscope me-1"></i> Motif</th>
                                <th><i class="fas fa-tag me-1"></i> Statut</th>
                                <th><i class="fas fa-cog me-1"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rendezVous as $rdv)
                            <tr>
                                <td>
                                    <div class="fw-semibold">Dr. {{ $rdv->medecin->user->name }}</div>
                                    <small class="text-muted">{{ $rdv->medecin->specialite }}</small>
                                </td>
                                <td>
                                    <div>{{ \Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y') }}</div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($rdv->date_heure)->format('H:i') }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary rounded-pill px-3 py-2">
                                        <i class="fas fa-notes-medical me-1"></i> {{ $rdv->motif ?? 'Non spécifié' }}
                                    </span>
                                </td>
                                <td>
                                    @if($rdv->statut == 'en_attente')
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                            <i class="fas fa-clock me-1"></i> En attente
                                        </span>
                                    @elseif($rdv->statut == 'confirme')
                                        <span class="badge bg-success rounded-pill px-3 py-2">
                                            <i class="fas fa-check me-1"></i> Confirmé
                                        </span>
                                    @elseif($rdv->statut == 'annule')
                                        <span class="badge bg-danger rounded-pill px-3 py-2">
                                            <i class="fas fa-times me-1"></i> Annulé
                                        </span>
                                    @else
                                        <span class="badge bg-info rounded-pill px-3 py-2">
                                            <i class="fas fa-check-double me-1"></i> Terminé
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($rdv->statut == 'en_attente')
                                    <form method="POST" action="{{ route('rendez-vous.destroy', $rdv->id) }}" onsubmit="return confirm('Annuler ce rendez-vous ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm rounded-3">
                                            <i class="fas fa-trash-alt me-1"></i> Annuler
                                        </button>
                                    </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Bouton rapide -->
    <div class="text-center mt-4">
        <a href="{{ route('rendez-vous.create') }}" class="btn btn-primary btn-lg px-5 rounded-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
            <i class="fas fa-calendar-plus me-2"></i> Prendre un nouveau rendez-vous
        </a>
    </div>
</div>

<style>
    .table th, .table td {
        vertical-align: middle;
        padding: 15px 12px;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s;
    }
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 1rem 2rem rgba(0,0,0,.1) !important;
    }
    .badge {
        font-weight: 500;
        font-size: 0.75rem;
    }
</style>
@endsection