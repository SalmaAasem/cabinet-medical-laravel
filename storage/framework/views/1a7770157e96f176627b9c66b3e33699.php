 <?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-4">Gestion de mon Planning</h2>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="<?php echo e(route('medecin.planning.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label text-muted small uppercase">Jour</label>
                        <select name="jour" class="form-select" required>
                            <option value="Monday">Lundi</option>
                            <option value="Tuesday">Mardi</option>
                            <option value="Wednesday">Mercredi</option>
                            <option value="Thursday">Jeudi</option>
                            <option value="Friday">Vendredi</option>
                            <option value="Saturday">Samedi</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-muted small">Début</label>
                        <input type="time" name="heure_debut" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-muted small">Fin</label>
                        <input type="time" name="heure_fin" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-muted small">Durée (min)</label>
                        <input type="number" name="duree_consultation" class="form-control" value="30" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive bg-white rounded shadow-sm">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Jour</th>
                    <th>Horaires</th>
                    <th>Consultation</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $plannings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="fw-bold"><?php echo e($p->jour); ?></td>
                    <td><?php echo e($p->heure_debut); ?> - <?php echo e($p->heure_fin); ?></td>
                    <td><?php echo e($p->duree_consultation); ?> min</td>
                    <td><span class="badge bg-success">Actif</span></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">Aucun planning configuré.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.simple', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pc\Downloads\cabinet-medical-laravel\cabinet-medical-laravel\resources\views/medecin/planning.blade.php ENDPATH**/ ?>