@extends('layouts.simple')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert"
                style="border-left: 5px solid #28a745;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-2x me-3 text-success"></i>
                    <div>
                        <strong class="d-block">Succès !</strong>
                        {{ session('success') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg border-0 rounded-4 mb-4"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body p-4 text-white">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 class="fw-bold mb-2">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    Mes rendez-vous
                                </h2>
                                <p class="mb-0 opacity-75">Consultez l'historique de vos rendez-vous médicaux</p>
                            </div>
                            <div class="col-md-4 text-center">
                                <i class="fas fa-calendar-check fa-4x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            @php
                $stats = [
                    [
                        'label' => 'En attente',
                        'count' => $rendezVous->where('statut', 'en_attente')->count(),
                        'icon' => 'clock',
                        'color' => 'warning',
                    ],
                    [
                        'label' => 'Confirmés',
                        'count' => $rendezVous->where('statut', 'confirme')->count(),
                        'icon' => 'check-circle',
                        'color' => 'success',
                    ],
                    [
                        'label' => 'Annulés',
                        'count' => $rendezVous->where('statut', 'annule')->count(),
                        'icon' => 'times-circle',
                        'color' => 'danger',
                    ],
                    [
                        'label' => 'Terminés',
                        'count' => $rendezVous->where('statut', 'termine')->count(),
                        'icon' => 'flag-checkered',
                        'color' => 'info',
                    ],
                ];
            @endphp
            @foreach ($stats as $stat)
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                        <div class="card-body">
                            <i class="fas fa-{{ $stat['icon'] }} fa-3x text-{{ $stat['color'] }} mb-2"></i>
                            <h3 class="fw-bold mb-0">{{ $stat['count'] }}</h3>
                            <p class="text-muted mb-0">{{ $stat['label'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h4 class="mb-0 fw-bold">
                    <i class="fas fa-list me-2 text-primary"></i> Liste de mes rendez-vous
                </h4>
            </div>
            <div class="card-body p-4">
                @if ($rendezVous->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-calendar-times fa-4x mb-3 opacity-25"></i>
                        <p class="mb-0">Aucun rendez-vous pour le moment.</p>
                        <a href="{{ route('rendez-vous.create') }}" class="btn btn-primary mt-3 rounded-3">Prendre un
                            rendez-vous</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Médecin</th>
                                    <th>Date et heure</th>
                                    <th>Motif</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rendezVous as $rdv)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">Dr. {{ $rdv->medecin->user->name ?? 'Médecin' }}</div>
                                            <small
                                                class="text-muted">{{ $rdv->medecin->specialite ?? 'Généraliste' }}</small>
                                        </td>
                                        <td>
                                            <div class="text-dark fw-bold">
                                                <i class="far fa-calendar-alt me-1 text-primary"></i>
                                                {{ $rdv->date_rdv ? \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') : '---' }}
                                            </div>
                                            <div class="small text-muted">
                                                <i class="far fa-clock me-1"></i>
                                                {{ $rdv->heure_rdv ? \Carbon\Carbon::parse($rdv->heure_rdv)->format('H:i') : '---' }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
                                                {{ $rdv->motif ?? 'Non spécifié' }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $badges = [
                                                    'en_attente' => 'bg-warning text-dark',
                                                    'confirme' => 'bg-success text-white',
                                                    'annule' => 'bg-danger text-white',
                                                    'termine' => 'bg-info text-white',
                                                ];
                                                $labels = [
                                                    'en_attente' => 'En attente',
                                                    'confirme' => 'Confirmé',
                                                    'annule' => 'Annulé',
                                                    'termine' => 'Terminé',
                                                ];
                                            @endphp
                                            <span
                                                class="badge {{ $badges[$rdv->statut] ?? 'bg-secondary' }} rounded-pill px-3 py-2">
                                                {{ $labels[$rdv->statut] ?? $rdv->statut }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($rdv->statut == 'en_attente')
                                                <form method="POST" action="{{ route('rendez-vous.destroy', $rdv->id) }}"
                                                    onsubmit="return confirm('Voulez-vous vraiment annuler ce rendez-vous ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                        <i class="fas fa-trash-alt me-1"></i> Annuler
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted small">Aucune action</span>
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

        <div class="text-center mt-4">
            <a href="{{ route('rendez-vous.create') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                <i class="fas fa-calendar-plus me-2"></i> Prendre un nouveau rendez-vous
            </a>
        </div>
    </div>

    <style>
        .table th {
            border-top: none;
            color: #764ba2;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .badge {
            font-weight: 600;
        }
    </style>
@endsection
