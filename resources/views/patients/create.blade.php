@extends('layouts.simple')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h3 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i> Ajouter un patient
                    </h3>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-triangle me-2"></i> Veuillez corriger les erreurs ci-dessous.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('patients.store') }}" autocomplete="off">
                        @csrf

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label fw-bold">
                                    <i class="fas fa-user text-primary me-1"></i> Nom complet
                                </label>
                                <input type="text" name="name" id="name" class="form-control form-control-lg rounded-3 @error('name') is-invalid @enderror" 
                                       placeholder="Ex: Fatima Zahra" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label fw-bold">
                                    <i class="fas fa-envelope text-primary me-1"></i> Email
                                </label>
                                <input type="email" name="email" id="email" class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror" 
                                       placeholder="Ex: patient@example.com" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="telephone" class="form-label fw-bold">
                                    <i class="fas fa-phone text-primary me-1"></i> Téléphone
                                </label>
                                <input type="text" name="telephone" id="telephone" class="form-control form-control-lg rounded-3 @error('telephone') is-invalid @enderror" 
                                       placeholder="Ex: 06 12 34 56 78" value="{{ old('telephone') }}" required>
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="date_naissance" class="form-label fw-bold">
                                    <i class="fas fa-calendar-alt text-primary me-1"></i> Date de naissance
                                </label>
                                <input type="date" name="date_naissance" id="date_naissance" class="form-control form-control-lg rounded-3 @error('date_naissance') is-invalid @enderror" 
                                       value="{{ old('date_naissance') }}" required>
                                @error('date_naissance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="adresse" class="form-label fw-bold">
                                    <i class="fas fa-home text-primary me-1"></i> Adresse
                                </label>
                                <textarea name="adresse" id="adresse" rows="3" class="form-control form-control-lg rounded-3 @error('adresse') is-invalid @enderror" 
                                          placeholder="Ex: 123 Rue de Paris, Casablanca" required>{{ old('adresse') }}</textarea>
                                @error('adresse')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                            <button type="reset" class="btn btn-secondary btn-lg px-4 rounded-3">
                                <i class="fas fa-eraser me-2"></i> Effacer
                            </button>
                            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                <i class="fas fa-save me-2"></i> Ajouter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102,126,234,0.25);
    }
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection