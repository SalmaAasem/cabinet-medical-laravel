@extends('layouts.app') @section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-file-medical"></i> Historique Médical : {{ $patient->name }}</h3>
            <a href="{{ url()->previous() }}" class="btn btn-light btn-sm">Retour</a>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Nom complet :</strong> {{ $patient->name }}</p>
                    <p><strong>Email :</strong> {{ $patient->email }}</p>
                </div>
                <div class="col-md-6 text-md-right">
                    <span class="badge badge-info p-2">Dossier Informatisé</span>
                </div>
            </div>

            <hr>

            <h4 class="mt-4 mb-3 text-secondary">Liste des Consultations Passées</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Date</th>
                            <th>Médecin</th>
                            <th>Diagnostic</th>
                            <th>Traitement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patient->consultations as $consultation)
                        <tr>
                            <td>{{ $consultation->created_at->format('d/m/Y') }}</td>
                            <td>Dr. {{ $consultation->medecin->name }}</td>
                            <td>{{ Str::limit($consultation->diagnostic, 50) }}</td>
                            <td>{{ Str::limit($consultation->traitement, 50) }}</td>
                            <td>
                                <a href="#" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-file-pdf"></i> Ordonnance
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Aucun historique trouvé pour ce patient.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection