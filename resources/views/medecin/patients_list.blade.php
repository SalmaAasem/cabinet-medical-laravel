@extends('layouts.simple') {{-- استعملت نفس الـ layout اللي وريتيني قبيلة --}}

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-4 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4">
                    <h2 class="fw-bold mb-0"><i class="fas fa-users me-2"></i> Gestion des Patients</h2>
                    <p class="opacity-75">Consultez l'historique médical et gérez vos patients.</p>
</div>

                    {{-- هاد السطر هو اللي زدت باش يبان زر الرجوع --}}
                    <a href="{{ route('medecin.rendez-vous') }}" class="btn btn-light rounded-pill px-4 shadow fw-bold position-absolute" 
               style="top: 50%; right: 25px; transform: translateY(-50%); color: #764ba2;">
                        <i class="fas fa-arrow-left me-1"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="patientsTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0">Patient</th>
                            <th class="border-0">Contact</th>
                            <th class="border-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $patient)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($patient->user->name, 0, 1)) }}
                                    </div>
                                    <h6 class="mb-0 fw-bold">{{ $patient->user->name }}</h6>
                                </div>
                            </td>
                            <td>{{ $patient->user->email }}</td>
                            <td class="text-end">
                                <a href="{{ route('medecin.patient.history', $patient->id) }}" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-eye me-1"></i> Voir Historique
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar { font-weight: bold; font-size: 1.1rem; }
    tr:hover { background-color: #f8f9ff; transition: 0.3s; }
</style>
@endsection