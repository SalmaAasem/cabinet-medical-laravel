

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-4 mb-4 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-0"><i class="fas fa-file-medical me-2"></i> Mon Historique Médical</h2>
                    <p class="mb-0 opacity-75">Consultez vos diagnostics et traitements passés.</p>
                </div>
                
                <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-light rounded-pill px-4">
                    <i class="fas fa-arrow-left me-1"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="avatar text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; background: #667eea; font-size: 1.5rem; font-weight: bold;">
                    <?php echo e(strtoupper(substr($patient->user->name, 0, 1))); ?>

                </div>
                <div>
                    <h4 class="fw-bold mb-0"><?php echo e($patient->user->name); ?></h4>
                    <p class="text-muted mb-0 small"><?php echo e($patient->user->email); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0">Date</th>
                            <th class="border-0">Médecin</th>
                            <th class="border-0">Diagnostic</th>
                            <th class="border-0">Traitement</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $consultations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consultation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="fw-bold text-primary"><?php echo e($consultation->created_at->format('d/m/Y')); ?></td>
                            <td>Dr. <?php echo e($consultation->medecin->user->name); ?></td>
                            <td><?php echo e($consultation->diagnostic); ?></td>
                            <td>
                                <span class="badge bg-light text-dark border p-2 fw-normal">
                                    <?php echo e($consultation->traitement); ?>

                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Aucun historique trouvé.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.simple', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cabinet-medical-laravel\resources\views/patients/historique.blade.php ENDPATH**/ ?>