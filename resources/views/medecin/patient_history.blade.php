@extends('layouts.simple')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">
            <i class="fas fa-history text-primary me-2"></i> Historique Médical
        </h3>
        <a href="{{ route('medecin.patients.index') }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                    {{ strtoupper(substr($patient->user->name, 0, 1)) }}
                </div>
                <div>
                    <h4 class="mb-0 fw-bold">{{ $patient->user->name }}</h4>
                    <p class="text-muted mb-0">{{ $patient->user->email }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="timeline">
        @forelse($patient->consultations as $consultation)
            <div class="card shadow-sm border-0 rounded-4 mb-3 border-start border-primary border-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-light text-primary rounded-pill px-3 py-2">
                            <i class="fas fa-calendar-alt me-1"></i> {{ $consultation->created_at->format('d M Y') }}
                        </span>
                        <small class="text-muted">ID: #{{ $consultation->id }}</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold text-dark"><i class="fas fa-stethoscope me-2 text-info"></i> Diagnostic</h6>
                            <p class="text-muted bg-light p-3 rounded-3">{{ $consultation->diagnostic }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="fw-bold text-dark"><i class="fas fa-pills me-2 text-success"></i> Traitement</h6>
                            <p class="text-muted bg-light p-3 rounded-3">{{ $consultation->traitement }}</p>
                        </div>
                    </div>

                    @if($consultation->notes)
                    <div class="mt-2">
                        <h6 class="fw-bold text-dark"><i class="fas fa-sticky-note me-2 text-warning"></i> Notes additionnelles</h6>
                        <p class="small text-muted">{{ $consultation->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3 opacity-25"></i>
                <p class="text-muted">Aucune consultation trouvée pour ce patient.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .card { transition: transform 0.2s; }
    .card:hover { transform: scale(1.01); }
</style>
@endsection