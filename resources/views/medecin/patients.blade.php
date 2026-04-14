@extends('layouts.simple')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-4 mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body p-4 text-white">
            <h2 class="fw-bold mb-2">
                <i class="fas fa-users me-2"></i> 
                Mes patients
            </h2>
            <p class="mb-0 opacity-75">Liste de tous vos patients</p>
        </div>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <h4 class="mb-0 fw-bold">Patients</h4>
        </div>
        <div class="card-body p-4">
            @if($patients->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="fas fa-user-slash fa-4x mb-3 opacity-25"></i>
                    <p>Aucun patient pour le moment.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patients as $patient)
                            <tr>
                                <td>{{ $patient->user->name }}</td>
                                <td>{{ $patient->user->email }}</td>
                                <td>{{ $patient->telephone ?? 'Non renseigné' }}</td>
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