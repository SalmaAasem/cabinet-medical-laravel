

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
                                <i class="fas fa-calendar-alt me-2"></i> 
                                Gestion des rendez-vous
                            </h2>
                            <p class="mb-0 opacity-75">
                                Gérez tous les rendez-vous du cabinet médical
                            </p>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-calendar-check fa-4x opacity-50"></i>
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
                    <i class="fas fa-times-circle fa-3x text-danger mb-2"></i>
                    <h3 class="fw-bold mb-0"><?php echo e($rendezVous->where('statut', 'annule')->count()); ?></h3>
                    <p class="text-muted mb-0">Annulés</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                <div class="card-body">
                    <i class="fas fa-flag-checkered fa-3x text-info mb-2"></i>
                    <h3 class="fw-bold mb-0"><?php echo e($rendezVous->where('statut', 'termine')->count()); ?></h3>
                    <p class="text-muted mb-0">Terminés</p>
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
                <i class="fas fa-list me-2 text-primary"></i> Liste des rendez-vous
            </h4>
        </div>
        <div class="card-body p-4">
            <?php if($rendezVous->isEmpty()): ?>
                <div class="text-center text-muted py-5">
                    <i class="fas fa-calendar-times fa-4x mb-3 opacity-25"></i>
                    <p class="mb-0">Aucun rendez-vous pour le moment.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-user me-1"></i> Patient</th>
                                <th><i class="fas fa-user-md me-1"></i> Médecin</th>
                                <th><i class="fas fa-calendar me-1"></i> Date et heure</th>
                                <th><i class="fas fa-tag me-1"></i> Statut</th>
                                <th><i class="fas fa-cog me-1"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $rendezVous; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rdv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="fw-semibold"><?php echo e($rdv->patient->user->name ?? 'N/A'); ?></td>
                                <td>Dr. <?php echo e($rdv->medecin->user->name ?? 'N/A'); ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y H:i')); ?></td>
                                <td>
                                    <select onchange="updateStatut(<?php echo e($rdv->id); ?>, this.value)" class="form-select form-select-sm w-auto d-inline-block" style="width: auto;">
                                        <option value="en_attente" <?php echo e($rdv->statut == 'en_attente' ? 'selected' : ''); ?> class="text-warning">🟡 En attente</option>
                                        <option value="confirme" <?php echo e($rdv->statut == 'confirme' ? 'selected' : ''); ?> class="text-success">🟢 Confirmé</option>
                                        <option value="annule" <?php echo e($rdv->statut == 'annule' ? 'selected' : ''); ?> class="text-danger">🔴 Annulé</option>
                                        <option value="termine" <?php echo e($rdv->statut == 'termine' ? 'selected' : ''); ?> class="text-info">🔵 Terminé</option>
                                    </select>
                                </td>
                                <td>
                                    <form method="POST" action="<?php echo e(route('gestion-rdv.destroy', $rdv->id)); ?>" style="display:inline-block" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous ?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm rounded-3">
                                            <i class="fas fa-trash-alt"></i> Annuler
                                        </button>
                                    </form>
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

<script>
    function updateStatut(id, statut) {
        fetch('/gestion-rdv/' + id, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ statut: statut })
        }).then(response => {
            if(response.ok) {
                location.reload();
            } else {
                alert('Erreur lors de la mise à jour');
            }
        });
    }
</script>

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
    .form-select-sm {
        font-size: 0.85rem;
        border-radius: 20px;
        padding: 5px 25px 5px 12px;
    }
    .btn-sm {
        border-radius: 20px;
        padding: 5px 15px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.simple', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pc\Downloads\cabinet-medical-laravel\cabinet-medical-laravel\resources\views/gestion-rdv/index.blade.php ENDPATH**/ ?>