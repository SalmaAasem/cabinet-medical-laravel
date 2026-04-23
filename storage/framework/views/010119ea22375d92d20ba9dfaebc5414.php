<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-4 mb-4"
        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body p-4 text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">
                        <i class="fas fa-file-medical-alt me-2"></i>

                        Dossier Médical de : <?php echo e($patient->user->name); ?>

                    </h2>
                    <p class="mb-0 opacity-75">Consultation des diagnostics et traitements du patient.</p>
                </div>
                <div class="ms-auto">

                    <?php if(auth()->user()->role === 'admin'): ?>
                    <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm">
                        <i class="fas fa-arrow-left me-2"></i> Retour
                    </a>
                    <?php else: ?>
                    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm">
                        <i class="fas fa-arrow-left me-2"></i> Retour
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm"
                    style="width: 65px; height: 65px; font-size: 1.5rem; font-weight: bold;">
                    <?php echo e(strtoupper(substr($patient->user->name, 0, 1))); ?>

                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-dark"><?php echo e($patient->user->name); ?></h4>
                    <p class="text-muted mb-0"><?php echo e($patient->user->email); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="text-secondary border-bottom">
                            <th class="pb-3 fw-bold">Date</th>
                            <th class="pb-3 fw-bold">Médecin</th>
                            <th class="pb-3 fw-bold">Diagnostic</th>
                            <th class="pb-3 fw-bold">Traitement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $patient->consultations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consultation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-bottom-0">
                            <td class="py-3 fw-semibold text-dark">
                                <?php echo e($consultation->created_at->format('d/m/Y')); ?>

                            </td>
                            <td class="py-3 text-muted">

                                Dr. <?php echo e($consultation->rendezVous->medecin->user->name ?? 'N/A'); ?>

                            </td>
                            <td class="py-3 text-dark">
                                <?php echo e($consultation->diagnostic); ?>

                            </td>
                            <td class="py-3">
                                <span
                                    class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2">
                                    <?php echo e($consultation->traitement); ?>

                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="opacity-50">
                                    <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i>
                                    <p class="text-muted fw-bold">Aucun historique trouvé.</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .table thead th {
        border-top: none;
        background-color: #f8f9fa;
        padding: 15px;
    }

    .table tbody td {
        padding: 15px;
    }

    .bg-primary-subtle {
        background-color: #e7f1ff !important;
    }

    .card {
        transition: all 0.3s ease;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.simple', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pc\Downloads\cabinet-medical-laravel\cabinet-medical-laravel\resources\views/medecin/patient_history.blade.php ENDPATH**/ ?>
