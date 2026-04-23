@extends('layouts.simple')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-4 mb-4 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-0"><i class="fas fa-user-edit me-2"></i> Modifier le Patient</h2>
                    <p class="mb-0 opacity-75">Mise à jour des informations de dossier.</p>
                </div>
                {{-- زر الرجوع للـ Liste --}}
                <a href="{{ route('patients.index') }}" class="btn btn-light rounded-pill px-4">
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
                    <p class="text-muted mb-0 small">Modification en cours...</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('patients.update', $patient->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small uppercase">Nom Complet</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-user text-primary"></i></span>
                            <input type="text" name="name" class="form-control border-0 bg-light p-3" value="{{ old('name', $patient->user->name) }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold text-muted small uppercase">Téléphone</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-phone text-primary"></i></span>
                            <input type="text" name="telephone" class="form-control border-0 bg-light p-3" value="{{ old('telephone', $patient->telephone) }}" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold text-muted small uppercase">Date de Naissance</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-calendar-alt text-primary"></i></span>
                            <input type="date" name="date_naissance" class="form-control border-0 bg-light p-3" value="{{ old('date_naissance', $patient->date_naissance) }}" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-bold text-muted small uppercase">Adresse Résidentielle</label>
                        <textarea name="adresse" rows="3" class="form-control border-0 bg-light p-3" required>{{ old('adresse', $patient->adresse) }}</textarea>
                    </div>

                    <div class="col-md-12 text-end pt-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold" style="background: #667eea; border: none;">
                            <i class="fas fa-save me-2"></i> Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection