@extends('layouts.simple')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-4 mb-4 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-0"><i class="fas fa-file-medical me-2"></i> Mon Historique Médical</h2>
                    <p class="mb-0 opacity-75">Consultez vos diagnostics et traitements passés.</p>
                </div>
                {{-- الزر كيرجع للـ Dashboard نيشان --}}
                <a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill px-4">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="avatar text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; background: #667eea; font-size: 1.5rem; font-weight: bold;">
                    {{ strtoupper(substr($patient->user->name, 0, 1)) }}
                </div>
                <div>
                    <h4 class="fw-bold mb-0">{{ $patient->user->name }}</h4>
                    <p class="text-muted mb-0 small">{{ $patient->user->email }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0">Date</th>
                            <th class="border-0">Médecin</th>
                            <th class="border-0">Diagnostic</th>
                            <th class="border-0">Traitement</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultations as $consultation)
                        <tr>
                            <td class="fw-bold text-primary">{{ $consultation->created_at->format('d/m/Y') }}</td>
                            <td>Dr. {{ $consultation->medecin->user->name }}</td>
                            <td>{{ $consultation->diagnostic }}</td>
                            <td>
                                <span class="badge bg-light text-dark border p-2 fw-normal">
                                    {{ $consultation->traitement }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Aucun historique trouvé.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection