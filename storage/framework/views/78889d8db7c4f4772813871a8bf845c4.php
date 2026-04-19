<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Modifier utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color:#f0f2f5; }
        .sidebar { width:260px; min-height:100vh; background:linear-gradient(180deg,#1e293b,#0f172a); position:fixed; top:0; left:0; z-index:100; display:flex; flex-direction:column; }
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
        <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="fas fa-chart-pie"></i> Tableau de bord</a>
        <a href="<?php echo e(route('admin.users')); ?>" class="active"><i class="fas fa-users"></i> Utilisateurs</a>
        <a href="<?php echo e(route('patients.index')); ?>"><i class="fas fa-user-injured"></i> Patients</a>
        <a href="<?php echo e(route('gestion-rdv.index')); ?>"><i class="fas fa-calendar-alt"></i> Rendez-vous</a>
        <a href="<?php echo e(route('dashboard')); ?>"><i class="fas fa-home"></i> Dashboard général</a>
    </nav>
    <div class="p-3 border-top" style="border-color:#334155!important">
        <form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?>
            <button class="btn btn-sm w-100" style="background:rgba(239,68,68,.15);color:#f87171;border:none">
                <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
            </button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="topbar d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold">Modifier l'utilisateur</h5>
            <small class="text-muted"><?php echo e($user->name); ?></small>
        </div>
        <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="p-4">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="bg-white rounded-3 shadow-sm border p-4">

                    
                    <div class="text-center mb-4">
                        <div class="rounded-circle text-white d-inline-flex align-items-center justify-content-center fw-bold mb-2"
                             style="width:64px;height:64px;font-size:1.4rem;background:linear-gradient(135deg,#6366f1,#a855f7)">
                            <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

                        </div>
                        <div class="text-muted small">ID #<?php echo e($user->id); ?></div>
                    </div>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger rounded-3 mb-4">
                            <ul class="mb-0 ps-3">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('admin.users.update', $user->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nom complet <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>"
                                   class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>"
                                   class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Rôle <span class="text-danger">*</span></label>
                            <select name="role" class="form-select <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="admin"      <?php echo e(old('role', $user->role) == 'admin' ? 'selected' : ''); ?>>Administrateur</option>
                                <option value="medecin"    <?php echo e(old('role', $user->role) == 'medecin' ? 'selected' : ''); ?>>Médecin</option>
                                <option value="secretaire" <?php echo e(old('role', $user->role) == 'secretaire' ? 'selected' : ''); ?>>Secrétaire</option>
                                <option value="patient"    <?php echo e(old('role', $user->role) == 'patient' ? 'selected' : ''); ?>>Patient</option>
                            </select>
                            <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <hr class="my-4">
                        <p class="text-muted small mb-3"><i class="fas fa-info-circle me-1"></i>Laisser vide pour ne pas changer le mot de passe.</p>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nouveau mot de passe</label>
                            <input type="password" name="password"
                                   class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="Minimum 8 caractères">
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control" placeholder="Répéter le mot de passe">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1 py-2 fw-semibold">
                                <i class="fas fa-save me-2"></i>Enregistrer
                            </button>
                            <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-outline-secondary px-4">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\cabinet-medical-laravel\resources\views/admin/users-edit.blade.php ENDPATH**/ ?>