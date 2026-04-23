

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-secondary"><i class="fas fa-clock-rotate-left me-2"></i>Historique des rendez-vous</h4>
                <a href="<?php echo e(route('patients.index')); ?>" class="btn btn-outline-secondary rounded-pill px-4">Retour</a>
            </div>
            
            <div class="alert alert-info border-0 rounded-4 shadow-sm mb-4">
                <strong>Patient:</strong> <?php echo e($patient->user->name); ?>

            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Date du RDV</th>
                            <th>Médecin</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $patient->rendezVous; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rdv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e(\Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y')); ?></td>
                            <td>Dr. <?php echo e($rdv->medecin->user->name ?? 'Médecin inconnu'); ?></td>
                            <td><span class="badge bg-secondary rounded-pill px-3"><?php echo e($rdv->statut); ?></span></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.simple', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pc\Downloads\cabinet-medical-laravel\cabinet-medical-laravel\resources\views/secretaire/patient_history.blade.php ENDPATH**/ ?>