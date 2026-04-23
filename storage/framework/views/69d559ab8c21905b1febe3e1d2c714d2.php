

<?php $__env->startSection('content'); ?>
    <div class="container mt-4">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert"
                style="border-left: 5px solid #28a745;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-2x me-3 text-success"></i>
                    <div>
                        <strong class="d-block">Succès !</strong>
                        <?php echo e(session('success')); ?>

                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg border-0 rounded-4 mb-4"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body p-4 text-white">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 class="fw-bold mb-2">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    Mes rendez-vous
                                </h2>
                                <p class="mb-0 opacity-75">Consultez l'historique de vos rendez-vous médicaux</p>
                            </div>
                            <div class="col-md-4 text-center">
                                <i class="fas fa-calendar-check fa-4x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <?php
                $stats = [
                    [
                        'label' => 'En attente',
                        'count' => $rendezVous->where('statut', 'en_attente')->count(),
                        'icon' => 'clock',
                        'color' => 'warning',
                    ],
                    [
                        'label' => 'Confirmés',
                        'count' => $rendezVous->where('statut', 'confirme')->count(),
                        'icon' => 'check-circle',
                        'color' => 'success',
                    ],
                    [
                        'label' => 'Annulés',
                        'count' => $rendezVous->where('statut', 'annule')->count(),
                        'icon' => 'times-circle',
                        'color' => 'danger',
                    ],
                    [
                        'label' => 'Terminés',
                        'count' => $rendezVous->where('statut', 'termine')->count(),
                        'icon' => 'flag-checkered',
                        'color' => 'info',
                    ],
                ];
            ?>
            <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-3">
                    <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                        <div class="card-body">
                            <i class="fas fa-<?php echo e($stat['icon']); ?> fa-3x text-<?php echo e($stat['color']); ?> mb-2"></i>
                            <h3 class="fw-bold mb-0"><?php echo e($stat['count']); ?></h3>
                            <p class="text-muted mb-0"><?php echo e($stat['label']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h4 class="mb-0 fw-bold">
                    <i class="fas fa-list me-2 text-primary"></i> Liste de mes rendez-vous
                </h4>
            </div>
            <div class="card-body p-4">
                <?php if($rendezVous->isEmpty()): ?>
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-calendar-times fa-4x mb-3 opacity-25"></i>
                        <p class="mb-0">Aucun rendez-vous pour le moment.</p>
                        <a href="<?php echo e(route('rendez-vous.create')); ?>" class="btn btn-primary mt-3 rounded-3">Prendre un
                            rendez-vous</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Médecin</th>
                                    <th>Date et heure</th>
                                    <th>Motif</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $rendezVous; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rdv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">Dr. <?php echo e($rdv->medecin->user->name ?? 'Médecin'); ?></div>
                                            <small
                                                class="text-muted"><?php echo e($rdv->medecin->specialite ?? 'Généraliste'); ?></small>
                                        </td>
                                        <td>
                                            <div class="text-dark fw-bold">
                                                <i class="far fa-calendar-alt me-1 text-primary"></i>
                                                <?php echo e($rdv->date_rdv ? \Carbon\Carbon::parse($rdv->date_rdv)->format('d/m/Y') : '---'); ?>

                                            </div>
                                            <div class="small text-muted">
                                                <i class="far fa-clock me-1"></i>
                                                <?php echo e($rdv->heure_rdv ? \Carbon\Carbon::parse($rdv->heure_rdv)->format('H:i') : '---'); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
                                                <?php echo e($rdv->motif ?? 'Non spécifié'); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <?php
                                                $badges = [
                                                    'en_attente' => 'bg-warning text-dark',
                                                    'confirme' => 'bg-success text-white',
                                                    'annule' => 'bg-danger text-white',
                                                    'termine' => 'bg-info text-white',
                                                ];
                                                $labels = [
                                                    'en_attente' => 'En attente',
                                                    'confirme' => 'Confirmé',
                                                    'annule' => 'Annulé',
                                                    'termine' => 'Terminé',
                                                ];
                                            ?>
                                            <span
                                                class="badge <?php echo e($badges[$rdv->statut] ?? 'bg-secondary'); ?> rounded-pill px-3 py-2">
                                                <?php echo e($labels[$rdv->statut] ?? $rdv->statut); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <?php if($rdv->statut == 'en_attente'): ?>
                                                <form method="POST" action="<?php echo e(route('rendez-vous.destroy', $rdv->id)); ?>"
                                                    onsubmit="return confirm('Voulez-vous vraiment annuler ce rendez-vous ?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit"
                                                        class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                                        <i class="fas fa-trash-alt me-1"></i> Annuler
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted small">Aucune action</span>
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

        <div class="text-center mt-4">
            <a href="<?php echo e(route('rendez-vous.create')); ?>" class="btn btn-primary btn-lg px-5 rounded-pill shadow"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                <i class="fas fa-calendar-plus me-2"></i> Prendre un nouveau rendez-vous
            </a>
        </div>
    </div>

    <style>
        .table th {
            border-top: none;
            color: #764ba2;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .badge {
            font-weight: 600;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.simple', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pc\Downloads\cabinet-medical-laravel\cabinet-medical-laravel\resources\views/rendezvous/index.blade.php ENDPATH**/ ?>