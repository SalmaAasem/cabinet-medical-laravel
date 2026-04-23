@extends('layouts.simple')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-4 mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body p-4 text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1"><i class="fas fa-file-medical-alt me-2"></i> Mon Dossier Médical</h2>
                    <p class="mb-0 opacity-75">Consultez vos diagnostics, traitements et ordonnances passés.</p>
                </div>
                <div class="ms-auto">
                <a href="{{ route('rendez-vous.index') }}" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center justify-content-center" style="height: 50px;">
                    <i class="fas fa-arrow-left me-2"></i> Retour
                </a>
            </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-body p-4 text-center">
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow-sm" style="width: 70px; height: 70px; font-size: 1.8rem; font-weight: bold;">
                        {{ strtoupper(substr($patient->user->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold text-dark mb-1">{{ $patient->user->name }}</h5>
                    <p class="text-muted small mb-3">{{ $patient->user->email }}</p>
                    <hr class="my-3 opacity-50">
                    <div class="text-start">
                        <div class="mb-2"><small class="text-muted d-block">Téléphone</small><span class="fw-semibold">{{ $patient->telephone }}</span></div>
                        <div class="mb-2"><small class="text-muted d-block">N° Sécurité Sociale</small><span class="fw-semibold text-primary">{{ $patient->num_secu ?? 'N/A' }}</span></div>
                        <div><small class="text-muted d-block">Adresse</small><span class="fw-semibold">{{ $patient->adresse }}</span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <h5 class="fw-bold mb-3 text-dark"><i class="fas fa-notes-medical text-primary me-2"></i> Historique des soins</h5>
            
            @forelse($consultations as $consultation)
                <div class="card shadow-sm border-0 rounded-4 mb-3 border-start border-4 border-primary">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-light text-primary rounded-pill px-3 py-2 fw-bold">
                                <i class="fas fa-calendar-alt me-1"></i> {{ $consultation->created_at->format('d M Y') }}
                            </span>
                            <span class="text-muted small">
                                <strong>Dr.</strong> {{ $consultation->rendezVous->medecin->user->name ?? 'Médecin' }}
                            </span>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 border-end">
                                <h6 class="fw-bold text-secondary small text-uppercase">Diagnostic</h6>
                                <p class="mb-0 text-dark">{{ $consultation->diagnostic }}</p>
                            </div>
                            <div class="col-md-6 ps-md-4">
                                <h6 class="fw-bold text-secondary small text-uppercase">Traitement</h6>
                                <p class="mb-0 text-primary fw-bold">{{ $consultation->traitement }}</p>
                            </div>
                        </div>

                        {{-- عرض الوصفة الطبية إذا وجدت --}}
                        @if($consultation->ordonnance)
                        <div class="mt-3 p-3 bg-light rounded-3 border-start border-4 border-success">
                            <h6 class="fw-bold text-success mb-2 small"><i class="fas fa-prescription me-2"></i> ORDONNANCE :</h6>
                            <p class="mb-0 text-muted small shadow-none border-0 bg-transparent">{{ $consultation->ordonnance->contenu }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="card shadow-sm border-0 rounded-4 p-5 text-center">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3 opacity-25"></i>
                    <p class="text-muted">Aucun historique médical disponible pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .card { transition: transform 0.2s ease-in-out; }
    .card:hover { transform: translateY(-3px); }
</style>
@endsection