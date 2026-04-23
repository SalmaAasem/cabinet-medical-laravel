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
            min-height: 100vh;
            padding-bottom: 50px;
        }

        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 50px;
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

        .form-control,
        .form-select {
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
            margin-top: 20px;
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

        .role-section {
            display: none;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
            border-left: 5px solid #667eea;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="register-card">
                    <div class="register-header">
                        <i class="fas fa-user-plus fa-3x mb-3"></i>
                        <h2>Créer un compte</h2>
                        <p>Inscrivez-vous pour accéder à nos services</p>
                    </div>
                    <div class="register-body">
                        <form method="POST" action="{{ route('register') }}" autocomplete="off">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom complet</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Adresse email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Rôle</label>
                                <select name="role" id="roleSelect" class="form-select" required>
                                    <option value="" disabled selected>Choisir un rôle...</option>
                                    <option value="patient" {{ old('role') == 'patient' ? 'selected' : '' }}>Patient
                                    </option>
                                    <option value="medecin" {{ old('role') == 'medecin' ? 'selected' : '' }}>Médecin
                                    </option>
                                    <option value="secretaire" {{ old('role') == 'secretaire' ? 'selected' : '' }}>
                                        Secrétaire</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur
                                    </option>
                                </select>
                            </div>

                            <div id="patientSection" class="role-section">
                                <h5 class="mb-3"><i class="fas fa-hospital-user me-2"></i>Dossier Patient</h5>
                                <div class="mb-3">
                                    <label class="form-label">Téléphone</label>
                                    <input type="text" name="telephone" class="form-control"
                                        value="{{ old('telephone') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Date de naissance</label>
                                    <input type="date" name="date_naissance" class="form-control"
                                        value="{{ old('date_naissance') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Adresse</label>
                                    <textarea name="adresse" class="form-control" rows="2">{{ old('adresse') }}</textarea>
                                </div>
                            </div>

                            <div id="medecinSection" class="role-section">
                                <h5 class="mb-3"><i class="fas fa-user-md me-2"></i>Informations Professionnelles</h5>
                                <div class="mb-3">
                                    <label class="form-label">Spécialité</label>
                                    <select name="specialite" class="form-select">
                                        <option value="" disabled selected>Choisir une spécialité...</option>
                                        <option value="Generaliste">Généraliste</option>
                                        <option value="Cardiologue">Cardiologue</option>
                                        <option value="Pediatre">Pédiatre</option>
                                        <option value="Dermatologue">Dermatologue</option>
                                        <option value="Dentiste">Dentiste</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Diplôme</label>
                                    <input type="text" name="diplome" class="form-control"
                                        value="{{ old('diplome') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Années d'expérience</label>
                                    <input type="number" name="annee_experience" class="form-control"
                                        value="{{ old('annee_experience') }}" min="0">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mot de passe</label>
                                    <input type="password" name="password" class="form-control" required
                                        autocomplete="new-password">
                                    @error('password')
                                        <span class="text-danger" style="font-size: 0.8rem;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Confirmer</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        required>
                                </div>
                            </div>

                            <button type="submit" class="btn-register shadow">S'inscrire maintenant</button>

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
        document.getElementById('roleSelect').addEventListener('change', function() {
            const patientSection = document.getElementById('patientSection');
            const medecinSection = document.getElementById('medecinSection');


            patientSection.style.display = 'none';
            medecinSection.style.display = 'none';


            if (this.value === 'patient') {
                patientSection.style.display = 'block';
            } else if (this.value === 'medecin') {
                medecinSection.style.display = 'block';
            }
        });


        window.addEventListener('DOMContentLoaded', (event) => {
            const role = document.getElementById('roleSelect').value;
            if (role) document.getElementById('roleSelect').dispatchEvent(new Event('change'));
        });
    </script>
</body>

</html>
