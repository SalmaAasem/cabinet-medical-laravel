<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header Card - Même couleur que les autres pages -->
            <div class="card shadow-lg border-0 rounded-4 mb-4"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-2">
                                <i class="fas fa-calendar-plus me-2"></i>
                                Prendre un rendez-vous
                            </h2>
                            <p class="mb-0 opacity-75">
                                Remplissez le formulaire ci-dessous pour réserver une consultation
                            </p>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="fas fa-stethoscope fa-4x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h4 class="mb-0 fw-bold">
                        <i class="fas fa-edit text-primary me-2"></i> Nouveau rendez-vous
                    </h4>
                </div>
                <div class="card-body p-4">
                    <?php if($errors->any()): ?>
                    <div class="alert alert-danger rounded-4 shadow-sm mb-4">
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><i class="fas fa-exclamation-circle me-2"></i><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo e(route('rendez-vous.store')); ?>">
                        <?php echo csrf_field(); ?>

                        <input type="hidden" name="patient_id" value="<?php echo e(request('patient_id')); ?>">

                        <div class="mb-4">
                            <label class="form-label fw-bold"><i
                                    class="fas fa-user-md text-primary me-2"></i>Médecin</label>
                            <select name="medecin_id" id="medecin_id"
                                class="form-select form-select-lg rounded-3 shadow-sm" required>
                                <option value="">-- Choisir un médecin --</option>
                                <?php $__currentLoopData = $medecins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medecin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($medecin->id); ?>">Dr. <?php echo e($medecin->user->name); ?> - <?php echo e($medecin->specialite); ?>
                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold"><i
                                        class="fas fa-calendar-alt text-primary me-2"></i>Date</label>
                                <input type="date" name="date_rdv"
                                    class="form-control form-control-lg rounded-3 shadow-sm" required>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold"><i
                                        class="fas fa-clock text-primary me-2"></i>Heure</label>
                                <input type="time" name="heure_rdv"
                                    class="form-control form-control-lg rounded-3 shadow-sm" required>
                            </div>
                        </div>

                        <!-- Motif -->
                        <div class="mb-4">
                            <label for="motif" class="form-label fw-bold">
                                <i class="fas fa-stethoscope text-primary me-1"></i> Motif (optionnel)
                            </label>
                            <select name="motif" id="motif" class="form-select form-select-lg rounded-3">
                                <option value="">-- Choisir un motif --</option>
                                <option value="Consultation générale">Consultation générale</option>
                                <option value="Consultation de suivi">Consultation de suivi</option>
                                <option value="Urgence">Urgence</option>
                                <option value="Contrôle">Contrôle</option>
                                <option value="Prise de sang">Prise de sang</option>
                                <option value="Vaccination">Vaccination</option>
                                <option value="Certificat médical">Certificat médical</option>
                                <option value="Douleur thoracique">Douleur thoracique</option>
                                <option value="Hypertension">Hypertension</option>
                                <option value="Fièvre">Fièvre</option>
                                <option value="Grippe">Grippe</option>
                                <option value="Angine">Angine</option>
                                <option value="Allergies">Allergies</option>
                            </select>
                        </div>

                        <!-- Message pour utilisateur connecté -->
                        <?php if(auth()->guard()->check()): ?>
                        <div class="alert alert-info rounded-3 mb-4"
                            style="background: #f0e6ff; border-color: #667eea;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-circle fa-2x me-3" style="color: #667eea;"></i>
                                <div>
                                    <strong class="fs-5">Vous êtes connecté</strong><br>
                                    <span>Compte : <?php echo e(Auth::user()->name); ?> (<?php echo e(Auth::user()->role); ?>)</span>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Boutons -->
                        <div class="d-flex gap-3 mt-4">
                            <a href="<?php echo e(route('dashboard')); ?>"
                                class="btn btn-outline-secondary btn-lg px-4 rounded-3 flex-grow-1">
                                <i class="fas fa-times me-2"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-3 flex-grow-1"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                <i class="fas fa-check-circle me-2"></i> Réserver
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informations supplémentaires -->
            <div class="row mt-4 g-3">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-3 text-center p-2 bg-light">
                        <small class="text-muted">
                            <i class="fas fa-clock" style="color: #667eea;"></i> Durée : 30 min
                        </small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-3 text-center p-2 bg-light">
                        <small class="text-muted">
                            <i class="fas fa-phone" style="color: #667eea;"></i> Annulation -24h
                        </small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-3 text-center p-2 bg-light">
                        <small class="text-muted">
                            <i class="fas fa-envelope" style="color: #667eea;"></i> Confirmation email
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.25);
    }

    .card {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1.5rem 3rem rgba(0, 0, 0, .15) !important;
    }

    .btn {
        transition: all 0.3s;
        font-weight: 500;
    }

    .btn:hover {
        transform: translateY(-2px);
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('date_rdv');
        const medecinSelect = document.getElementById('medecin_id');
        const container = document.getElementById('slots-container');
        const section = document.getElementById('available-slots-section');
        const selectedInput = document.getElementById('selected_slot');

        function updateSlots() {
            const date = dateInput.value;
            const medecinId = medecinSelect.value;

            if (date && medecinId) {
                container.innerHTML = '<p class="text-muted">Chargement...</p>';
                section.style.display = 'block';

                fetch(`/api/available-slots?date=${date}&medecin_id=${medecinId}`)
                    .then(res => res.json())
                    .then(slots => {
                        container.innerHTML = '';
                        if (slots.length === 0 || slots.message) {
                            container.innerHTML =
                                '<p class="text-danger">Aucun créneau disponible pour ce jour.</p>';
                            return;
                        }

                        slots.forEach(slot => {
                            const btn = document.createElement('button');
                            btn.type = 'button';
                            btn.className = 'btn btn-outline-primary m-1 slot-btn';
                            btn.style.width = '80px';
                            btn.innerText = slot;
                            btn.onclick = function() {

                                document.querySelectorAll('.slot-btn').forEach(b => {
                                    b.classList.replace('btn-primary',
                                        'btn-outline-primary');
                                });
                                this.classList.replace('btn-outline-primary', 'btn-primary');

                                selectedInput.value = slot;
                            };
                            container.appendChild(btn);
                        });
                    });
            }
        }

        dateInput.addEventListener('change', updateSlots);
        medecinSelect.addEventListener('change', updateSlots);
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.simple', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\pc\Downloads\cabinet-medical-laravel\cabinet-medical-laravel\resources\views/rendezvous/create.blade.php ENDPATH**/ ?>
