@extends('layouts.simple')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg border-0 rounded-4 mb-4"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body p-4 text-white">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 class="fw-bold mb-2">
                                    <i class="fas fa-stethoscope me-2"></i> Mes consultations
                                </h2>
                                <p class="mb-0 opacity-75">
                                    Bienvenue Dr. {{ Auth::user()->name }}, gérez vos consultations et ordonnances ici
                                </p>
                            </div>
                            <div class="col-md-4 text-center d-none d-md-block">
                                <i class="fas fa-user-md fa-4x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 text-center p-3 h-100">
                    <div class="card-body">
                        <i class="fas fa-calendar-alt fa-2x text-primary mb-2"></i>
                        <h3 class="fw-bold mb-0">{{ $rendezVous->count() }}</h3>
                        <p class="text-muted small mb-0">Total RDV</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 text-center p-3 h-100">
                    <div class="card-body">
                        <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                        <h3 class="fw-bold mb-0">{{ $rendezVous->where('statut', 'en_attente')->count() }}</h3>
                        <p class="text-muted small mb-0">En attente</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 text-center p-3 h-100">
                    <div class="card-body">
                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                        <h3 class="fw-bold mb-0">{{ $rendezVous->where('statut', 'confirme')->count() }}</h3>
                        <p class="text-muted small mb-0">Confirmés</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 text-center p-3 h-100">
                    <div class="card-body">
                        <i class="fas fa-flag-checkered fa-2x text-info mb-2"></i>
                        <h3 class="fw-bold mb-0">{{ $rendezVous->filter(fn($r) => $r->consultation()->exists())->count() }}
                        </h3>
                        <p class="text-muted small mb-0">Consultations faites</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold">
                    <i class="fas fa-list me-2 text-primary"></i> Liste des patients
                </h4>
            </div>
            <div class="card-body p-4">
                @if ($rendezVous->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-times fa-4x mb-3 opacity-25"></i>
                        <p class="text-muted">Aucun rendez-vous pour le moment.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Patient</th>
                                    <th>Date & Heure</th>
                                    <th>Statut</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rendezVous as $rdv)
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $rdv->patient->user->name ?? 'Inconnu' }}
                                            </div>
                                            <small class="text-muted"><i
                                                    class="fas fa-comment-medical me-1 small"></i>{{ $rdv->motif }}</small>
                                        </td>
                                        <td>
                                            <div class="small fw-semibold">
                                                {{ \Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y') }}</div>
                                            <div class="text-muted small">
                                                {{ \Carbon\Carbon::parse($rdv->date_heure)->format('H:i') }}</div>
                                        </td>
                                        <td>
                                            @php $consultation = $rdv->consultation; @endphp
                                            @if ($consultation)
                                                <span
                                                    class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3">
                                                    <i class="fas fa-check-double me-1"></i> Terminé
                                                </span>
                                            @else
                                                <span
                                                    class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">
                                                    <i class="fas fa-clock me-1"></i> {{ ucfirst($rdv->statut) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                @if ($consultation)
                                                    {{-- إذا كاين استشارة، كيبان زر العرض والـ PDF فقط --}}
                                                    <a href="{{ route('medecin.consultation.show', $consultation->id) }}"
                                                        class="btn btn-sm btn-outline-info rounded-pill px-3">
                                                        <i class="fas fa-eye me-1"></i> Voir
                                                    </a>
                                                    <a href="{{ route('medecin.consultation.pdf', $consultation->id) }}"
                                                        class="btn btn-sm btn-danger rounded-pill px-3">
                                                        <i class="fas fa-file-pdf me-1"></i> Ordonnance PDF
                                                    </a>
                                                @else
                                                    {{-- إذا مازال، كيبان زر الإضافة --}}
                                                    <a href="{{ route('medecin.consultation.create', $rdv->id) }}"
                                                        class="btn btn-sm btn-primary rounded-pill px-3 shadow-sm">
                                                        <i class="fas fa-plus-circle me-1"></i> Ajouter Consultation
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .table thead th {
            border-top: none;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6c757d;
        }

        .btn-sm {
            font-size: 0.8rem;
            font-weight: 500;
        }

        .badge {
            font-size: 0.75rem;
        }

        .bg-info-subtle {
            background-color: #e0f7fa !important;
        }

        .bg-success-subtle {
            background-color: #e8f5e9 !important;
        }
    </style>
@endsection
