<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | Cabinet Médical</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .register-body {
            padding: 40px;
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 15px;
        }
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: bold;
            width: 100%;
            color: white;
        }
        .btn-register:hover {
            transform: scale(1.02);
            color: white;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
        .login-link a {
            color: #667eea;
            text-decoration: none;
        }
        .form-label {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="register-card">
                    <div class="register-header">
                        <i class="fas fa-user-plus fa-3x mb-3"></i>
                        <h2>Créer un compte</h2>
                        <p>Inscrivez-vous pour accéder à nos services</p>
                    </div>
                    <div class="register-body">
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}" autocomplete="off">
                            @csrf

                            <!-- Nom complet -->
                            <div class="mb-3">
                                <label class="form-label">Nom complet</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autocomplete="off">
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Adresse email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="off">
                            </div>

                            <!-- Rôle -->
                            <div class="mb-3">
                                <label class="form-label">Rôle</label>
                                <select name="role" id="role" class="form-select" required>
                                    <option value="patient" {{ old('role') == 'patient' ? 'selected' : '' }}>Patient</option>
                                    <option value="medecin" {{ old('role') == 'medecin' ? 'selected' : '' }}>Médecin</option>
                                    <option value="secretaire" {{ old('role') == 'secretaire' ? 'selected' : '' }}>Secrétaire</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                </select>
                            </div>

                            <!-- Champs pour PATIENT -->
                            <div class="mb-3" id="telephone-field" style="display: none;">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" name="telephone" class="form-control" value="{{ old('telephone') }}">
                            </div>

                            <div class="mb-3" id="date_naissance-field" style="display: none;">
                                <label class="form-label">Date de naissance</label>
                                <input type="date" name="date_naissance" class="form-control" value="{{ old('date_naissance') }}">
                            </div>

                            <div class="mb-3" id="adresse-field" style="display: none;">
                                <label class="form-label">Adresse</label>
                                <textarea name="adresse" class="form-control" rows="2">{{ old('adresse') }}</textarea>
                            </div>

                            <!-- Champs pour MÉDECIN -->
                            <div class="mb-3" id="specialite-field" style="display: none;">
                                <label class="form-label">Spécialité</label>
                                <input type="text" name="specialite" class="form-control" placeholder="Ex: Cardiologue, Dermatologue..." value="{{ old('specialite') }}">
                            </div>

                            <div class="mb-3" id="diplome-field" style="display: none;">
                                <label class="form-label">Diplôme</label>
                                <input type="text" name="diplome" class="form-control" placeholder="Ex: Doctorat en Médecine" value="{{ old('diplome') }}">
                            </div>

                            <div class="mb-3" id="experience-field" style="display: none;">
                                <label class="form-label">Années d'expérience</label>
                                <input type="number" name="annee_experience" class="form-control" placeholder="Ex: 5" value="{{ old('annee_experience') }}">
                            </div>

                            <!-- Mot de passe -->
                            <div class="mb-3">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="password" class="form-control" required autocomplete="new-password">
                            </div>

                            <!-- Confirmer mot de passe -->
                            <div class="mb-3">
                                <label class="form-label">Confirmer le mot de passe</label>
                                <input type="password" name="password_confirmation" class="form-control" required autocomplete="off">
                            </div>

                            <button type="submit" class="btn-register">S'inscrire</button>

                            <div class="login-link">
                                <span>Déjà inscrit ?</span>
                                <a href="{{ route('login') }}">Connectez-vous</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Afficher/masquer les champs selon le rôle choisi
        document.getElementById('role').addEventListener('change', function() {
            var isPatient = this.value === 'patient';
            var isMedecin = this.value === 'medecin';
            
            // Champs patient
            var telephoneField = document.getElementById('telephone-field');
            var dateNaissanceField = document.getElementById('date_naissance-field');
            var adresseField = document.getElementById('adresse-field');
            
            // Champs médecin
            var specialiteField = document.getElementById('specialite-field');
            var diplomeField = document.getElementById('diplome-field');
            var experienceField = document.getElementById('experience-field');
            
            var telephoneInput = document.querySelector('input[name="telephone"]');
            var dateNaissanceInput = document.querySelector('input[name="date_naissance"]');
            var adresseInput = document.querySelector('textarea[name="adresse"]');
            var specialiteInput = document.querySelector('input[name="specialite"]');
            var diplomeInput = document.querySelector('input[name="diplome"]');
            var experienceInput = document.querySelector('input[name="annee_experience"]');
            
            if (isPatient) {
                telephoneField.style.display = 'block';
                dateNaissanceField.style.display = 'block';
                adresseField.style.display = 'block';
                if (telephoneInput) telephoneInput.required = true;
                if (dateNaissanceInput) dateNaissanceInput.required = true;
                if (adresseInput) adresseInput.required = true;
            } else {
                telephoneField.style.display = 'none';
                dateNaissanceField.style.display = 'none';
                adresseField.style.display = 'none';
                if (telephoneInput) telephoneInput.required = false;
                if (dateNaissanceInput) dateNaissanceInput.required = false;
                if (adresseInput) adresseInput.required = false;
            }
            
            if (isMedecin) {
                specialiteField.style.display = 'block';
                diplomeField.style.display = 'block';
                experienceField.style.display = 'block';
                if (specialiteInput) specialiteInput.required = true;
                if (diplomeInput) diplomeInput.required = true;
                if (experienceInput) experienceInput.required = true;
            } else {
                specialiteField.style.display = 'none';
                diplomeField.style.display = 'none';
                experienceField.style.display = 'none';
                if (specialiteInput) specialiteInput.required = false;
                if (diplomeInput) diplomeInput.required = false;
                if (experienceInput) experienceInput.required = false;
            }
        });
        
        // Déclencher l'événement au chargement pour initialiser l'affichage
        document.addEventListener('DOMContentLoaded', function() {
            var event = new Event('change');
            document.getElementById('role').dispatchEvent(event);
        });
    </script>
</body>
</html>