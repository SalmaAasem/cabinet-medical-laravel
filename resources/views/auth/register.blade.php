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
                        <form method="POST" action="{{ route('register') }}" autocomplete="off">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nom complet</label>
                                <input type="text" name="name" class="form-control" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Adresse email</label>
                                <input type="email" name="email" class="form-control" required autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Rôle</label>
                                <select name="role" class="form-select" required>
                                    <option value="patient">Patient</option>
                                    <option value="medecin">Médecin</option>
                                    <option value="secretaire">Secrétaire</option>
                                    <option value="admin">Administrateur</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="password" class="form-control" required autocomplete="new-password">
                            </div>

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
</body>
</html>