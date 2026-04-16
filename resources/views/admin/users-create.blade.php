<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Créer un utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; }
        .sidebar { width:260px; min-height:100vh; background: linear-gradient(180deg,#1e293b,#0f172a); position:fixed; top:0; left:0; z-index:100; display:flex; flex-direction:column; }
        .sidebar-brand { padding:1.5rem; font-size:1.2rem; font-weight:700; color:#818cf8; border-bottom:1px solid #334155; }
        .sidebar-nav a { display:flex; align-items:center; gap:12px; padding:.85rem 1.5rem; color:#94a3b8; text-decoration:none; transition:all .2s; font-size:.9rem; }
        .sidebar-nav a:hover,.sidebar-nav a.active { color:#fff; background:rgba(129,140,248,.15); border-left:3px solid #818cf8; }
        .sidebar-nav a i { width:20px; text-align:center; }
        .main-content { margin-left:260px; min-height:100vh; }
        .topbar { background:#fff; padding:1rem 2rem; border-bottom:1px solid #e2e8f0; position:sticky; top:0; z-index:99; }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand"><i class="fas fa-shield-alt me-2"></i> Admin Panel</div>
    <nav class="sidebar-nav mt-3 flex-grow-1">
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-pie"></i> Tableau de bord</a>
        <a href="{{ route('admin.users') }}" class="active"><i class="fas fa-users"></i> Utilisateurs</a>
        <a href="{{ route('patients.index') }}"><i class="fas fa-user-injured"></i> Patients</a>
        <a href="{{ route('gestion-rdv.index') }}"><i class="fas fa-calendar-alt"></i> Rendez-vous</a>
        <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard général</a>
    </nav>
    <div class="p-3 border-top" style="border-color:#334155!important">
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button class="btn btn-sm w-100" style="background:rgba(239,68,68,.15);color:#f87171;border:none">
                <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold">Créer un utilisateur</h5>
            <small class="text-muted">Ajouter un nouveau compte</small>
        </div>
        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="p-4">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="bg-white rounded-3 shadow-sm border p-4">
                    <h6 class="fw-bold mb-4 text-muted text-uppercase" style="font-size:.75rem;letter-spacing:.5px">
                        <i class="fas fa-user-plus me-2 text-primary"></i>Informations du compte
                    </h6>

                    @if($errors->any())
                        <div class="alert alert-danger rounded-3 mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nom complet <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Ex: Dr. Ahmed Benali">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="email@exemple.com">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Rôle <span class="text-danger">*</span></label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror">
                                <option value="">-- Choisir un rôle --</option>
                                <option value="admin"      {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                <option value="medecin"    {{ old('role') == 'medecin' ? 'selected' : '' }}>Médecin</option>
                                <option value="secretaire" {{ old('role') == 'secretaire' ? 'selected' : '' }}>Secrétaire</option>
                                <option value="patient"    {{ old('role') == 'patient' ? 'selected' : '' }}>Patient</option>
                            </select>
                            @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mot de passe <span class="text-danger">*</span></label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Minimum 8 caractères">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirmer le mot de passe <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation"
                                   class="form-control" placeholder="Répéter le mot de passe">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="fas fa-user-plus me-2"></i>Créer l'utilisateur
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>