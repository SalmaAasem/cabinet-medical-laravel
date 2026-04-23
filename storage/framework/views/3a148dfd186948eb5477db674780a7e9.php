

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white p-3">
            <h4 class="mb-0">Détails de la Consultation</h4>
        </div>
        <div class="card-body p-4">
            <h5>Patient: <span class="text-muted"><?php echo e($consultation->patient->user->name); ?></span></h5>
            <hr>
            <div class="mb-3">
                <strong>Diagnostic:</strong>
                <p class="p-3 bg-light rounded"><?php echo e($consultation->diagnostic); ?></p>
            </div>
            <div class="mb-3">
                <strong>Traitement / Ordonnance:</strong>
                <p class="p-3 bg-light rounded"><?php echo e($consultation->traitement); ?></p>
            </div>
            <?php if($consultation->notes): ?>
            <div class="mb-3">
                <strong>Notes:</strong>
                <p class="p-3 bg-light rounded"><?php echo e($consultation->notes); ?></p>
            </div>
            <?php endif; ?>
            <a href="<?php echo e(route('medecin.rendez-vous')); ?>" class="btn btn-secondary rounded-pill">Retour</a>
            <a href="<?php echo e(route('medecin.consultation.pdf', $consultation->id)); ?>" class="btn btn-danger rounded-pill">Télécharger PDF</a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.simple', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pc\Downloads\cabinet-medical-laravel\cabinet-medical-laravel\resources\views/medecin/consultation_detail.blade.php ENDPATH**/ ?>