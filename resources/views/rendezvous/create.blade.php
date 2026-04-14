@extends('layouts.simple')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header Card -->
            <div class="card shadow-lg border-0 rounded-4 mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-2">
                                <i class="fas fa-calendar-plus me-2"></i> 
                                Prendre un rendez-vous
                            </h2>
                            <p class="mb-0 opacity-75">
                                Remplissez le formulaire ci-dessous pour réserver une consultation
                            </p>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-stethoscope fa-4x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-edit text-primary me-2"></i> Nouveau rendez-vous
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('rendez-vous.store') }}">
                        @csrf
                        
                        <!-- Médecin -->
                        <div class="mb-4">
                            <label for="medecin_id" class="form-label fw-bold">
                                <i class="fas fa-user-md text-primary me-1"></i> Médecin
                            </label>
                            <select name="medecin_id" id="medecin_id" class="form-select form-select-lg rounded-3 @error('medecin_id') is-invalid @enderror" required>
                                <option value="">-- Choisir un médecin --</option>
                                @foreach($medecins as $medecin)
                                    <option value="{{ $medecin->id }}">
                                        Dr. {{ $medecin->user->name }} - {{ $medecin->specialite }}
                                    </option>
                                @endforeach
                            </select>
                            @error('medecin_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Date et heure -->
                        <div class="mb-4">
                            <label for="date_heure" class="form-label fw-bold">
                                <i class="fas fa-calendar-alt text-primary me-1"></i> Date et heure
                            </label>
                            <input type="datetime-local" name="date_heure" id="date_heure" class="form-control form-control-lg rounded-3 @error('date_heure') is-invalid @enderror" required>
                            <small class="text-muted">Format: JJ/MM/AAAA HH:MM</small>
                            @error('date_heure')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Motif -->
                        <div class="mb-4">
                            <label for="motif" class="form-label fw-bold">
                                <i class="fas fa-stethoscope text-primary me-1"></i> Motif (optionnel)
                            </label>
                            <select name="motif" id="motif" class="form-select form-select-lg rounded-3">
                                <option value="">-- Choisir un motif --</option>
                                <option value="Consultation générale">Consultation générale</option>
                                <option value="Consultation de suivi">Consultation de suivi</option>
                                <option value="Urgence">Urgence</option>
                                <option value="Contrôle">Contrôle</option>
                                <option value="Prise de sang">Prise de sang</option>
                                <option value="Vaccination">Vaccination</option>
                                <option value="Certificat médical">Certificat médical</option>
                                <option value="Douleur thoracique">Douleur thoracique</option>
                                <option value="Hypertension">Hypertension</option>
                                <option value="Fièvre">Fièvre</option>
                                <option value="Grippe">Grippe</option>
                                <option value="Angine">Angine</option>
                                <option value="Allergies">Allergies</option>
                            </select>
                        </div>

                        <!-- Message pour utilisateur connecté -->
                        @auth
                            @if(Auth::user()->role == 'patient')
                                <!-- Patient connecté : pas besoin de ressaisir les infos -->
                                <div class="alert alert-info rounded-3 mb-4">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Vous êtes connecté en tant que : {{ Auth::user()->name }}</strong><br>
                                    Vos informations sont déjà enregistrées. Cliquez simplement sur "Réserver".
                                </div>
                                <input type="hidden" name="patient_name" value="{{ Auth::user()->name }}">
                                <input type="hidden" name="patient_email" value="{{ Auth::user()->email }}">
                                <input type="hidden" name="patient_telephone" value="{{ Auth::user()->patient->telephone ?? '' }}">
                                <input type="hidden" name="patient_date_naissance" value="{{ Auth::user()->patient->date_naissance ?? '' }}">
                                <input type="hidden" name="patient_adresse" value="{{ Auth::user()->patient->adresse ?? '' }}">
                            @else
                                <!-- Autre rôle connecté (médecin, admin) : afficher le formulaire -->
                                <h4>Vos informations</h4>
                                <div class="mb-3">
                                    <label>Nom complet</label>
                                    <input type="text" name="patient_name" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="patient_email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Téléphone</label>
                                    <input type="text" name="patient_telephone" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Date de naissance</label>
                                    <input type="date" name="patient_date_naissance" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label>Adresse</label>
                                    <textarea name="patient_adresse" class="form-control" rows="2"></textarea>
                                </div>
                            @endif
                        @else
                            <!-- Non connecté : afficher le formulaire complet -->
                            <h4>Vos informations</h4>
                            <div class="mb-3">
                                <label>Nom complet</label>
                                <input type="text" name="patient_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="patient_email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Téléphone</label>
                                <input type="text" name="patient_telephone" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Date de naissance</label>
                                <input type="date" name="patient_date_naissance" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Adresse</label>
                                <textarea name="patient_adresse" class="form-control" rows="2"></textarea>
                            </div>
                        @endauth

                        <!-- Boutons -->
                        <div class="d-flex gap-3 mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg px-4 rounded-3 flex-grow-1">
                                <i class="fas fa-times me-2"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-3 flex-grow-1" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                <i class="fas fa-check-circle me-2"></i> Réserver
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informations supplémentaires -->
            <div class="row mt-4 g-3">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-3 text-center p-2 bg-light">
                        <small class="text-muted">
                            <i class="fas fa-clock" style="color: #667eea;"></i> Durée : 30 min
                        </small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-3 text-center p-2 bg-light">
                        <small class="text-muted">
                            <i class="fas fa-phone" style="color: #667eea;"></i> Annulation -24h
                        </small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-3 text-center p-2 bg-light">
                        <small class="text-muted">
                            <i class="fas fa-envelope" style="color: #667eea;"></i> Confirmation email
                        </small>
                    </div>
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
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1.5rem 3rem rgba(0,0,0,.15) !important;
    }
    .btn {
        transition: all 0.3s;
        font-weight: 500;
    }
    .btn:hover {
        transform: translateY(-2px);
    }
</style>
@endsection