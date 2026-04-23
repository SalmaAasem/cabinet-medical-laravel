@extends('layouts.simple')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-secondary"><i class="fas fa-clock-rotate-left me-2"></i>Historique des rendez-vous</h4>
                <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Retour</a>
            </div>
            
            <div class="alert alert-info border-0 rounded-4 shadow-sm mb-4">
                <strong>Patient:</strong> {{ $patient->user->name }}
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Date du RDV</th>
                            <th>Médecin</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patient->rendezVous as $rdv)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') }}</td>
                            <td>Dr. {{ $rdv->medecin->user->name ?? 'Médecin inconnu' }}</td>
                            <td><span class="badge bg-secondary rounded-pill px-3">{{ $rdv->statut }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection