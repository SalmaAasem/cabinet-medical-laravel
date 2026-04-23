

<?php $__env->startSection('content'); ?>
    <div class="container mt-4">
        <!-- Header -->
        <div class="card shadow-lg border-0 rounded-4 mb-4"
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body p-4 text-white">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-2">
                            <i class="fas fa-users me-2"></i>
                            Liste des patients
                        </h2>
                        <p class="mb-0 opacity-75">Gérez tous les patients du cabinet</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <i class="fas fa-user-friends fa-4x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barre de recherche -->
        <div class="card shadow-lg border-0 rounded-4 mb-4">
            <div class="card-body p-4">
                <form method="GET" action="<?php echo e(route('patients.index')); ?>" class="row g-3">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="fas fa-search text-primary"></i>
                            </span>
                            <input type="text" name="search" class="form-control form-control-lg"
                                placeholder="Rechercher par nom, email ou téléphone..." value="<?php echo e($search ?? ''); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-lg w-100"
                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                            <i class="fas fa-search me-2"></i> Chercher
                        </button>
                    </div>
                </form>
                <?php if(isset($search)): ?>
                    <div class="mt-2">
                        <a href="<?php echo e(route('patients.index')); ?>" class="text-muted">
                            <i class="fas fa-times me-1"></i> Effacer la recherche
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x text-primary mb-2"></i>
                        <h3 class="fw-bold mb-0"><?php echo e($patients->count()); ?></h3>
                        <p class="text-muted mb-0">Patients trouvés</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tableau des patients -->
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h4 class="mb-0 fw-bold">
                    <i class="fas fa-list me-2 text-primary"></i> Tous les patients
                </h4>
            </div>
            <div class="card-body p-4">
                <?php if($patients->isEmpty()): ?>
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-user-slash fa-4x mb-3 opacity-25"></i>
                        <p class="mb-0">Aucun patient trouvé.</p>
                        <a href="<?php echo e(route('patients.create')); ?>" class="btn btn-primary mt-3 rounded-3">
                            <i class="fas fa-user-plus me-2"></i> Ajouter un patient
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="fas fa-user me-1"></i> Nom</th>
                                    <th><i class="fas fa-envelope me-1"></i> Email</th>
                                    <th><i class="fas fa-phone me-1"></i> Téléphone</th>
                                    <th><i class="fas fa-calendar me-1"></i> Date naissance</th>
                                    <th><i class="fas fa-home me-1"></i> Adresse</th>
                                    <th><i class="fas fa-cog me-1"></i> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="fw-semibold"><?php echo e($patient->user->name ?? 'N/A'); ?></div>
                                        </td>
                                        <td><?php echo e($patient->user->email ?? 'N/A'); ?></td>
                                        <td><?php echo e($patient->telephone); ?></td>
                                        <td><?php echo e($patient->date_naissance); ?></td>
                                        <td><?php echo e($patient->adresse); ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="<?php echo e(route('patients.edit', $patient->id)); ?>"
                                                    class="btn btn-sm btn-warning rounded-3">
                                                    <i class="fas fa-edit"></i> Modifier
                                                </a>

                                                <a href="<?php echo e(route('patients.historique', $patient->id)); ?>"
                                                    class="btn btn-sm btn-info rounded-3">
                                                    <i class="fas fa-history"></i> Historique
                                                </a>
                                            </div>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="<?php echo e(route('rendez-vous.create', ['patient_id' => $patient->id])); ?>"
                                                    class="btn btn-sm btn-success rounded-pill px-3 me-2"
                                                    title="Prendre rendez-vous">
                                                    <i class="fas fa-calendar-plus me-1"></i> Prendre RDV
                                                </a>
                                            </div>
                                        </td>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Bouton ajouter -->
        <div class="text-center mt-4">
            <a href="<?php echo e(route('patients.create')); ?>" class="btn btn-primary btn-lg px-5 rounded-3"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                <i class="fas fa-user-plus me-2"></i> Ajouter un patient
            </a>
        </div>
    </div>

    <style>
        .table th,
        .table td {
            vertical-align: middle;
            padding: 12px 10px;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .card {
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.simple', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pc\Downloads\cabinet-medical-laravel\cabinet-medical-laravel\resources\views/patients/index.blade.php ENDPATH**/ ?>