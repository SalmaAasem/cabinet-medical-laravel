

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            
            <div class="card shadow-lg border-0 rounded-4 mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-2">
                                <i class="fas fa-stethoscope me-2"></i> 
                                Bienvenue, <?php echo e(Auth::user()->name); ?> !
                            </h2>
                            <p class="mb-0 opacity-75">
                                <?php if(Auth::user()->role == 'patient'): ?>
                                    Vous êtes connecté en tant que patient.
                                <?php elseif(Auth::user()->role == 'medecin'): ?>
                                    Vous êtes connecté en tant que médecin.
                                <?php elseif(Auth::user()->role == 'secretaire'): ?>
                                    Vous êtes connecté en tant que secrétaire.
                                <?php elseif(Auth::user()->role == 'admin'): ?>
                                    Vous êtes connecté en tant qu'administrateur.
                                <?php endif; ?>
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

    
    <?php if(Auth::user()->role != 'patient'): ?>
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                <div class="card-body">
                    <i class="fas fa-calendar-check fa-3x text-primary mb-2"></i>
                    <h3 class="fw-bold mb-0"><?php echo e($rdvAujourdhui ?? 0); ?></h3>
                    <p class="text-muted mb-0 small">Rendez-vous aujourd'hui</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                <div class="card-body">
                    <i class="fas fa-users fa-3x text-primary mb-2" style="color: #667eea !important;"></i>
                    <h3 class="fw-bold mb-0"><?php echo e($totalPatients ?? 0); ?></h3>
                    <p class="text-muted mb-0 small">Patients total</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                <div class="card-body">
                    <i class="fas fa-user-md fa-3x text-info mb-2"></i>
                    <h3 class="fw-bold mb-0"><?php echo e($totalMedecins ?? 0); ?></h3>
                    <p class="text-muted mb-0 small">Médecins</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-4 text-center p-3">
                <div class="card-body">
                    <i class="fas fa-chart-line fa-3x text-warning mb-2"></i>
                    <h3 class="fw-bold mb-0"><?php echo e($consultationsMois ?? 0); ?></h3>
                    <p class="text-muted mb-0 small">Consultations ce mois</p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h4 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-bolt text-primary me-2"></i> Actions rapides
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        
                        
                        <?php if(Auth::user()->role == 'medecin'): ?>
                        <div class="col-md-6">
                            <a href="<?php echo e(route('medecin.rendez-vous')); ?>" class="btn btn-primary w-100 py-3 rounded-3 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                <i class="fas fa-calendar-check me-2"></i> Mes consultations
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="<?php echo e(route('medecin.patients.index')); ?>" class="btn btn-outline-primary w-100 py-3 rounded-3 shadow-sm">
                                <i class="fas fa-file-medical me-2"></i> Liste des Patients
                            </a>
                        </div>
                        <?php endif; ?>

                        
                        <?php if(Auth::user()->role == 'patient'): ?>
                        <div class="col-md-6">
                            <a href="<?php echo e(route('patient.my_history')); ?>" class="btn btn-primary w-100 py-3 rounded-3 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                <i class="fas fa-history me-2"></i> Mon Historique Médical
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="<?php echo e(route('rendez-vous.index')); ?>" class="btn btn-outline-primary w-100 py-3 rounded-3 shadow-sm">
                                <i class="fas fa-calendar-alt me-2"></i> Mes Rendez-vous
                            </a>
                        </div>
                        <?php endif; ?>

                        
                        <?php if(Auth::user()->role == 'secretaire' || Auth::user()->role == 'admin'): ?>
                        <div class="col-md-4">
                            <a href="<?php echo e(route('patients.create')); ?>" class="btn btn-primary w-100 py-3 rounded-3 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                <i class="fas fa-user-plus me-2"></i> Ajouter un patient
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="<?php echo e(route('patients.index')); ?>" class="btn btn-primary w-100 py-3 rounded-3 shadow-sm" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border: none;">
                                <i class="fas fa-list me-2"></i> Liste des Patients
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="<?php echo e(route('gestion-rdv.index')); ?>" class="btn btn-outline-primary w-100 py-3 rounded-3 shadow-sm">
                                <i class="fas fa-calendar-alt me-2"></i> Gérer les rendez-vous
                            </a>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-history text-primary me-2"></i> Activité récente
                    </h4>
                </div>
                <div class="card-body p-4 text-center text-muted">
                    <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                    <p class="mb-0">Aucune activité récente pour le moment.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card { transition: all 0.3s ease; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important; }
    .btn { transition: all 0.3s ease; font-weight: 500; }
    .btn:hover { transform: translateY(-2px); filter: brightness(1.1); }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.simple', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\cabinet-medical-laravel\resources\views/dashboard.blade.php ENDPATH**/ ?>