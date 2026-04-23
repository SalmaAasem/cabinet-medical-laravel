@extends('layouts.simple')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4 mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-2">
                                <i class="fas fa-stethoscope me-2"></i> 
                                Consultation médicale
                            </h2>
                            <p class="mb-0 opacity-75">Saisissez le compte-rendu et générez l'ordonnance PDF</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-notes-medical fa-4x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-user-circle fa-2x me-3" style="color: #667eea;"></i>
                                <div>
                                    <small class="text-muted">Patient</small>
                                    <h5 class="mb-0 fw-bold">{{ $rendezVous->patient->user->name ?? 'Patient non trouvé' }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-calendar-alt fa-2x me-3" style="color: #667eea;"></i>
                                <div>
                                    <small class="text-muted">Date de consultation</small>
                                    <h5 class="mb-0 fw-bold">{{ now()->format('d/m/Y H:i') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-edit text-primary me-2"></i> Compte-rendu
                    </h4>
                </div>
                <div class="card-body p-4">
                    {{-- Thabet ennou el route smitha 'medecin.consultation.store' f web.php --}}
                    <form method="POST" action="{{ route('medecin.consultation.store') }}">
                        @csrf
                        
                        {{-- Hidden Inputs: Darouriyin bech el controller i-identify l-patient w rdv --}}
                        <input type="hidden" name="rendez_vous_id" value="{{ $rendezVous->id }}">
                        <input type="hidden" name="patient_id" value="{{ $rendezVous->patient->id }}">
                        
                        <div class="mb-4">
                            <label for="diagnostic" class="form-label fw-bold">
                                <i class="fas fa-stethoscope text-primary me-1"></i> Diagnostic
                            </label>
                            <textarea name="diagnostic" id="diagnostic" rows="3" 
                                class="form-control form-control-lg rounded-3 @error('diagnostic') is-invalid @enderror" 
                                placeholder="Saisissez le diagnostic..." required>{{ old('diagnostic') }}</textarea>
                            @error('diagnostic')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="traitement" class="form-label fw-bold">
                                <i class="fas fa-prescription-bottle text-primary me-1"></i> Traitement / Prescription
                            </label>
                            <textarea name="traitement" id="traitement" rows="4" 
                                class="form-control form-control-lg rounded-3 @error('traitement') is-invalid @enderror" 
                                placeholder="Doliprane 1g, 3 fois par jour..." required>{{ old('traitement') }}</textarea>
                            @error('traitement')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-bold">
                                <i class="fas fa-pen-alt text-primary me-1"></i> Notes (optionnel)
                            </label>
                            <textarea name="notes" id="notes" rows="2" class="form-control form-control-lg rounded-3" 
                                      placeholder="Saisissez des notes supplémentaires...">{{ old('notes') }}</textarea>
                        </div>

                        <div class="d-flex gap-3 mt-4">
                            <a href="{{ route('medecin.rendez-vous') }}" class="btn btn-outline-secondary btn-lg px-4 rounded-3 flex-grow-1">
                                <i class="fas fa-arrow-left me-2"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-3 flex-grow-1" 
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                <i class="fas fa-file-pdf me-2"></i> Enregistrer & PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.25); }
    .card { transition: transform 0.2s, box-shadow 0.2s; }
    .card:hover { transform: translateY(-3px); box-shadow: 0 1rem 2rem rgba(0,0,0,.1) !important; }
    textarea { resize: vertical; }
</style>
@endsection