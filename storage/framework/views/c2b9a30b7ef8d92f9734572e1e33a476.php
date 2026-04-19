<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Admin - Gestion Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; }
        .sidebar {
            width: 260px; min-height: 100vh;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            position: fixed; top: 0; left: 0; z-index: 100;
            display: flex; flex-direction: column;
        }
        .sidebar-brand { padding: 1.5rem; font-size: 1.2rem; font-weight: 700; color: #818cf8; border-bottom: 1px solid #334155; }
        .sidebar-nav a {
            display: flex; align-items: center; gap: 12px;
            padding: 0.85rem 1.5rem; color: #94a3b8; text-decoration: none; transition: all 0.2s; font-size: 0.9rem;
        }
        .sidebar-nav a:hover, .sidebar-nav a.active { color: #fff; background: rgba(129,140,248,0.15); border-left: 3px solid #818cf8; }
        .sidebar-nav a i { width: 20px; text-align: center; }
        .main-content { margin-left: 260px; min-height: 100vh; }
        .topbar { background: #fff; padding: 1rem 2rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 99; }
        .role-badge { font-size: 0.7rem; padding: 3px 10px; border-radius: 20px; font-weight: 700; letter-spacing: 0.5px; }
        .role-admin     { background: #fde8e8; color: #c81e1e; }
        .role-medecin   { background: #e0f2fe; color: #0369a1; }
        .role-secretaire{ background: #fef9c3; color: #92400e; }
        .role-patient   { background: #dcfce7; color: #15803d; }
        .avatar { width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; }
        .table th { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; font-weight: 700; }
    </style>
</head>
<body>


<div class="sidebar">
    <div class="sidebar-brand">
        <i class="fas fa-shield-alt me-2"></i> Admin Panel
    </div>
    <nav class="sidebar-nav mt-3 flex-grow-1">
        <a href="<?php echo e(route('admin.dashboard')); ?>">
            <i class="fas fa-chart-pie"></i> Tableau de bord
        </a>
        <a href="<?php echo e(route('admin.users')); ?>" class="active">
            <i class="fas fa-users"></i> Utilisateurs
        </a>
        <a href="<?php echo e(route('patients.index')); ?>">
            <i class="fas fa-user-injured"></i> Patients
        </a>
        <a href="<?php echo e(route('gestion-rdv.index')); ?>">
            <i class="fas fa-calendar-alt"></i> Rendez-vous
        </a>
        <a href="<?php echo e(route('dashboard')); ?>">
            <i class="fas fa-home"></i> Dashboard général
        </a>
    </nav>
    <div class="p-3 border-top" style="border-color: #334155 !important;">
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button class="btn btn-sm w-100" style="background: rgba(239,68,68,0.15); color: #f87171; border: none;">
                <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
            </button>
        </form>
    </div>
</div>


<div class="main-content">
    <div class="topbar">
        <div>
            <h5 class="mb-0 fw-bold">Gestion des Utilisateurs</h5>
            <small class="text-muted"><?php echo e($users->total()); ?> utilisateurs au total</small>
        </div>
        <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-primary btn-sm px-3">
            <i class="fas fa-user-plus me-2"></i>Nouvel utilisateur
        </a>
    </div>

    <div class="p-4">
        
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-3" role="alert">
                <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-3" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        
        <div class="bg-white rounded-3 p-3 mb-3 shadow-sm border">
            <form method="GET" action="<?php echo e(route('admin.users')); ?>" class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label small fw-semibold text-muted mb-1">Recherche</label>
                    <div class="input-group">
                        <span class="input-group-text border-end-0 bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                               class="form-control border-start-0" placeholder="Nom ou email...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1">Rôle</label>
                    <select name="role" class="form-select">
                        <option value="">Tous les rôles</option>
                        <option value="admin"      <?php echo e(request('role') == 'admin' ? 'selected' : ''); ?>>Administrateur</option>
                        <option value="medecin"    <?php echo e(request('role') == 'medecin' ? 'selected' : ''); ?>>Médecin</option>
                        <option value="secretaire" <?php echo e(request('role') == 'secretaire' ? 'selected' : ''); ?>>Secrétaire</option>
                        <option value="patient"    <?php echo e(request('role') == 'patient' ? 'selected' : ''); ?>>Patient</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                </div>
                <div class="col-md-2">
                    <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-outline-secondary w-100">Réinitialiser</a>
                </div>
            </form>
        </div>

        
        <div class="bg-white rounded-3 shadow-sm border overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Utilisateur</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Inscrit le</th>
                            <th class="text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar text-white"
                                         style="background: hsl(<?php echo e(crc32($user->name) % 360); ?>, 60%, 50%)">
                                        <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark"><?php echo e($user->name); ?></div>
                                        <div class="text-muted small">#<?php echo e($user->id); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-muted small"><?php echo e($user->email); ?></td>
                            <td>
                                <span class="role-badge role-<?php echo e($user->role ?? 'patient'); ?>">
                                    <?php echo e(ucfirst($user->role ?? 'patient')); ?>

                                </span>
                            </td>
                            <td class="text-muted small"><?php echo e($user->created_at->format('d/m/Y')); ?></td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    
                                    <a href="<?php echo e(route('admin.users.edit', $user->id)); ?>"
                                       class="btn btn-sm btn-outline-primary" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <?php if($user->id !== Auth::id()): ?>
                                    <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST"
                                          onsubmit="return confirm('Supprimer <?php echo e($user->name); ?> ?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    <?php else: ?>
                                    <button class="btn btn-sm btn-outline-secondary" disabled title="Votre compte">
                                        <i class="fas fa-lock"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-users fa-3x mb-3 d-block opacity-25"></i>
                                Aucun utilisateur trouvé
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            
            <?php if($users->hasPages()): ?>
            <div class="p-3 border-top d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Affichage <?php echo e($users->firstItem()); ?>–<?php echo e($users->lastItem()); ?> sur <?php echo e($users->total()); ?>

                </small>
                <?php echo e($users->withQueryString()->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\cabinet-medical-laravel\resources\views/admin/users.blade.php ENDPATH**/ ?>