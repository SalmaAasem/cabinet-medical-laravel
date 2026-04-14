@extends('layouts.simple')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-4 mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body p-4 text-white">
            <h2 class="fw-bold mb-2">Gestion des patients</h2>
            <p class="mb-0 opacity-75">Liste de tous les patients</p>
        </div>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <h4 class="mb-0 fw-bold">Liste des patients</h4>
        </div>
        <div class="card-body p-4">
            @if($patients->isEmpty())
                <div class="text-center text-muted py-5">
                    <p>Aucun patient trouvé.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Date naissance</th>
                                <th>Adresse</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patients as $patient)
                            <tr>
                                <td>{{ $patient->id }}</td>
                                <td>{{ $patient->user->name ?? 'N/A' }}</td>
                                <td>{{ $patient->user->email ?? 'N/A' }}</td>
                                <td>{{ $patient->telephone ?? 'N/A' }}</td>
                                <td>{{ $patient->date_naissance ?? 'N/A' }}</td>
                                <td>{{ $patient->adresse ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection