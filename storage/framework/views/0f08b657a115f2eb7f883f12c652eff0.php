<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Cabinet Médical</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="<?php echo e(route('dashboard')); ?>">
                <i class="fas fa-clinic-medical"></i> Cabinet Médical
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <?php if(auth()->guard()->check()): ?>
                        
                        <?php if(Auth::user()->role == 'patient'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('rendez-vous.create')); ?>">Prendre RDV</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('rendez-vous.index')); ?>">Mes RDV</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('patient.my_history')); ?>"> Mon Dossier Médical</a>
                            </li>
                        <?php endif; ?>

                        
                        <?php if(Auth::user()->role == 'medecin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('medecin.rendez-vous')); ?>">Mes consultations</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('medecin.patients.index')); ?>">Liste patients</a>
                            </li>
                        <?php endif; ?>

                        
                        <?php if(Auth::user()->role == 'secretaire' || Auth::user()->role == 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('patients.create')); ?>">Ajouter patient</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('patients.index')); ?>">Liste patients</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo e(route('gestion-rdv.index')); ?>">Gestion RDV</a>
                            </li>
                        <?php endif; ?>

                        <?php if(Auth::user()->role == 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link text-danger" href="#"><i class="fas fa-user-shield"></i>
                                    Administration</a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item ms-lg-3">
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                                </button>
                            </form>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if(session('success')): ?>
            <div class="alert alert-success border-0 shadow-sm"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if(session('error') && session('error') != 'Vous n\'avez pas de dossier patient.'): ?>
            <div class="alert alert-danger border-0 shadow-sm"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php /**PATH C:\Users\pc\Downloads\cabinet-medical-laravel\cabinet-medical-laravel\resources\views/layouts/simple.blade.php ENDPATH**/ ?>