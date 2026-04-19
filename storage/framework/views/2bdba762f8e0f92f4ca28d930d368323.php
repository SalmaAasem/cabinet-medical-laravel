

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-4 mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-2">
                                <i class="fas fa-stethoscope me-2"></i> 
                                Mes consultations
                            </h2>
                            <p class="mb-0 opacity-75">
                                Bienvenue Dr. <?php echo e(Auth::user()->name); ?>, gérez vos consultations ici
                            </p>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-user-md fa-4x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                <div class="card-body">
                    <i class="fas fa-calendar-alt fa-3x text-primary mb-2"></i>
                    <h3 class="fw-bold mb-0"><?php echo e($rendezVous->count()); ?></h3>
                    <p class="text-muted mb-0">Total RDV</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                <div class="card-body">
                    <i class="fas fa-clock fa-3x text-warning mb-2"></i>
                    <h3 class="fw-bold mb-0"><?php echo e($rendezVous->where('statut', 'en_attente')->count()); ?></h3>
                    <p class="text-muted mb-0">En attente</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-3x text-success mb-2"></i>
                    <h3 class="fw-bold mb-0"><?php echo e($rendezVous->where('statut', 'confirme')->count()); ?></h3>
                    <p class="text-muted mb-0">Confirmés</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                <div class="card-body">
                    <i class="fas fa-flag-checkered fa-3x text-info mb-2"></i>
                    <h3 class="fw-bold mb-0"><?php echo e($rendezVous->where('statut', 'termine')->count()); ?></h3>
                    <p class="text-muted mb-0">Consultations faites</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-3" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Rendez-vous Table -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <h4 class="mb-0 fw-bold">
                <i class="fas fa-list me-2 text-primary"></i> Liste des patients
            </h4>
        </div>
        <div class="card-body p-4">
            <?php if($rendezVous->isEmpty()): ?>
                <div class="text-center text-muted py-5">
                    <i class="fas fa-calendar-times fa-4x mb-3 opacity-25"></i>
                    <p class="mb-0">Aucun rendez-vous pour le moment.</p>
                    <p class="small mt-2">Les patients peuvent prendre rendez-vous via le site.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-user me-1"></i> Patient</th>
                                <th><i class="fas fa-calendar me-1"></i> Date et heure</th>
                                <th><i class="fas fa-tag me-1"></i> Statut</th>
                                <th><i class="fas fa-cog me-1"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $rendezVous; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rdv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="fw-semibold"><?php echo e($rdv->patient->user->name ?? 'N/A'); ?></div>
                                    <small class="text-muted"><?php echo e($rdv->motif ?? 'Pas de motif'); ?></small>
                                </td>
                                <td><?php echo e(\Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y H:i')); ?></td>
                                <td>
                                    <?php if($rdv->statut == 'en_attente'): ?>
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                            <i class="fas fa-clock me-1"></i> En attente
                                        </span>
                                    <?php elseif($rdv->statut == 'confirme'): ?>
                                        <span class="badge bg-success px-3 py-2 rounded-pill">
                                            <i class="fas fa-check me-1"></i> Confirmé
                                        </span>
                                    <?php elseif($rdv->statut == 'annule'): ?>
                                        <span class="badge bg-danger px-3 py-2 rounded-pill">
                                            <i class="fas fa-times me-1"></i> Annulé
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-info px-3 py-2 rounded-pill">
                                            <i class="fas fa-check-double me-1"></i> Terminé
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($rdv->consultation): ?>
                                        <a href="<?php echo e(route('medecin.consultation.create', $rdv->id)); ?>" class="btn btn-info btn-sm rounded-3 me-1">
                                            <i class="fas fa-eye"></i> Voir
                                        </a>
                                        <a href="<?php echo e(route('ordonnance.pdf', $rdv->consultation->id)); ?>" class="btn btn-secondary btn-sm rounded-3">
                                            <i class="fas fa-file-pdf"></i> PDF
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('medecin.consultation.create', $rdv->id)); ?>" class="btn btn-primary btn-sm rounded-3">
                                            <i class="fas fa-plus-circle"></i> Ajouter consultation
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .table th, .table td {
        vertical-align: middle;
        padding: 15px 12px;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transition: background-color 0.2s;
    }
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 1rem 2rem rgba(0,0,0,.1) !important;
    }
    .btn-sm {
        border-radius: 20px;
        padding: 5px 15px;
    }
    .badge {
        font-weight: 500;
        font-size: 0.75rem;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.simple', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cabinet-medical-laravel\resources\views/medecin/rendez-vous.blade.php ENDPATH**/ ?>