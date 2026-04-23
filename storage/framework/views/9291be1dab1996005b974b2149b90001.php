<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Admin - Tableau de Bord</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        body {
            background-color: #f0f2f5;
        }

        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 1.5rem;
            font-size: 1.2rem;
            font-weight: 700;
            color: #818cf8;
            border-bottom: 1px solid #334155;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.85rem 1.5rem;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.9rem;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            color: #fff;
            background: rgba(129, 140, 248, 0.15);
            border-left: 3px solid #818cf8;
        }

        .sidebar-nav a i {
            width: 20px;
            text-align: center;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        .topbar {
            background: #fff;
            padding: 1rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-badge {
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .chart-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
        }

        .chart-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 1.2rem;
        }
    </style>
</head>

<body>

    
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="fas fa-shield-alt me-2"></i> Admin Panel
        </div>
        <nav class="sidebar-nav mt-3 flex-grow-1">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="active">
                <i class="fas fa-chart-pie"></i> Tableau de bord
            </a>
            <a href="<?php echo e(route('admin.users')); ?>">
                <i class="fas fa-users"></i> Utilisateurs
            </a>
            <a href="<?php echo e(route('patients.index')); ?>">
                <i class="fas fa-user-injured"></i> Patients
            </a>
            <a href="<?php echo e(route('gestion-rdv.index')); ?>">
                <i class="fas fa-calendar-alt"></i> Rendez-vous
            </a>

        </nav>
        <div class="p-3 border-top" style="border-color: #334155 !important;">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button class="btn btn-sm w-100"
                    style="background: rgba(239,68,68,0.15); color: #f87171; border: none;">
                    <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                </button>
            </form>
        </div>
    </div>

    
    <div class="main-content">
        <div class="topbar">
            <div>
                <h5 class="mb-0 fw-bold text-slate-800">Tableau de bord</h5>
                <small class="text-muted"><?php echo e(now()->format('d/m/Y')); ?></small>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                    <i class="fas fa-circle me-1" style="font-size:8px"></i> Administrateur
                </span>
                <strong class="text-slate-700"><?php echo e(Auth::user()->name); ?></strong>
            </div>
        </div>

        <div class="p-4">
            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="stat-icon" style="background:#eef2ff">
                                <i class="fas fa-users" style="color:#6366f1"></i>
                            </div>
                            <span class="badge bg-primary-subtle text-primary stat-badge">+<?php echo e($nouveauxUtilisateurs); ?>

                                cette semaine</span>
                        </div>
                        <div class="stat-value text-dark"><?php echo e($stats['total_users']); ?></div>
                        <div class="stat-label mt-1">Utilisateurs</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="stat-icon" style="background:#f0fdf4">
                                <i class="fas fa-user-injured" style="color:#22c55e"></i>
                            </div>
                        </div>
                        <div class="stat-value text-dark"><?php echo e($stats['total_patients']); ?></div>
                        <div class="stat-label mt-1">Patients</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="stat-icon" style="background:#fff7ed">
                                <i class="fas fa-user-md" style="color:#f97316"></i>
                            </div>
                        </div>
                        <div class="stat-value text-dark"><?php echo e($stats['total_medecins']); ?></div>
                        <div class="stat-label mt-1">Médecins</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="stat-icon" style="background:#fdf4ff">
                                <i class="fas fa-calendar-check" style="color:#a855f7"></i>
                            </div>
                        </div>
                        <div class="stat-value text-dark"><?php echo e($stats['total_rdv']); ?></div>
                        <div class="stat-label mt-1">Rendez-vous</div>
                    </div>
                </div>
            </div>

            
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="stat-card d-flex align-items-center gap-3">
                        <div class="stat-icon" style="background:#fef9c3">
                            <i class="fas fa-clock" style="color:#eab308"></i>
                        </div>
                        <div>
                            <div class="stat-value" style="font-size:1.5rem"><?php echo e($stats['rdv_en_attente']); ?></div>
                            <div class="stat-label">RDV en attente</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card d-flex align-items-center gap-3">
                        <div class="stat-icon" style="background:#dcfce7">
                            <i class="fas fa-check-circle" style="color:#16a34a"></i>
                        </div>
                        <div>
                            <div class="stat-value" style="font-size:1.5rem"><?php echo e($stats['rdv_confirmes']); ?></div>
                            <div class="stat-label">RDV confirmés</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card d-flex align-items-center gap-3">
                        <div class="stat-icon" style="background:#fee2e2">
                            <i class="fas fa-times-circle" style="color:#dc2626"></i>
                        </div>
                        <div>
                            <div class="stat-value" style="font-size:1.5rem"><?php echo e($stats['rdv_annules']); ?></div>
                            <div class="stat-label">RDV annulés</div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="row g-4 mb-4">
                
                <div class="col-lg-8">
                    <div class="chart-card">
                        <div class="chart-title">
                            <i class="fas fa-chart-line text-primary me-2"></i>
                            Activité sur les 6 derniers mois
                        </div>
                        <canvas id="activiteChart" height="100"></canvas>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="chart-card">
                        <div class="chart-title">
                            <i class="fas fa-chart-pie text-purple me-2" style="color:#a855f7"></i>
                            Statuts des rendez-vous
                        </div>
                        <canvas id="statutsChart" height="170"></canvas>
                        <div class="mt-3 d-flex flex-column gap-1">
                            <?php $__currentLoopData = $rdvStatuts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statut => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted"><?php echo e($statut); ?></small>
                                    <span class="badge bg-secondary-subtle text-secondary"><?php echo e($count); ?></span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                
                <div class="col-lg-5">
                    <div class="chart-card">
                        <div class="chart-title">
                            <i class="fas fa-chart-bar text-success me-2"></i>
                            Répartition par rôle
                        </div>
                        <canvas id="rolesChart" height="200"></canvas>
                    </div>
                </div>
                
                <div class="col-lg-7">
                    <div class="chart-card">
                        <div class="chart-title">
                            <i class="fas fa-trophy text-warning me-2"></i>
                            Top médecins (par rendez-vous)
                        </div>
                        <?php if($topMedecins->isEmpty()): ?>
                            <p class="text-muted text-center py-3">Aucun médecin enregistré</p>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Médecin</th>
                                            <th>Spécialité</th>
                                            <th class="text-center">RDV</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $topMedecins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $medecin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <?php if($i === 0): ?>
                                                        <i class="fas fa-medal text-warning"></i>
                                                    <?php elseif($i === 1): ?>
                                                        <i class="fas fa-medal text-secondary"></i>
                                                    <?php elseif($i === 2): ?>
                                                        <i class="fas fa-medal" style="color:#cd7f32"></i>
                                                    <?php else: ?>
                                                        <span class="text-muted"><?php echo e($i + 1); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold"
                                                            style="width:32px;height:32px;font-size:12px">
                                                            <?php echo e(strtoupper(substr($medecin->user->name ?? 'M', 0, 2))); ?>

                                                        </div>
                                                        <span
                                                            class="fw-semibold"><?php echo e($medecin->user->name ?? 'N/A'); ?></span>
                                                    </div>
                                                </td>
                                                <td><span
                                                        class="badge bg-info-subtle text-info"><?php echo e($medecin->specialite); ?></span>
                                                </td>
                                                <td class="text-center fw-bold"><?php echo e($medecin->rendez_vous_count); ?></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // === Données depuis Laravel ===
        const moisLabels = <?php echo json_encode(array_column($rdvParMois, 'mois'), 512) ?>;
        const rdvData = <?php echo json_encode(array_column($rdvParMois, 'total'), 512) ?>;
        const consultData = <?php echo json_encode(array_column($consultationsParMois, 'total'), 512) ?>;
        const statutLabels = <?php echo json_encode(array_keys($rdvStatuts), 15, 512) ?>;
        const statutData = <?php echo json_encode(array_values($rdvStatuts), 15, 512) ?>;
        const roleLabels = <?php echo json_encode(array_keys($usersParRole), 15, 512) ?>;
        const roleData = <?php echo json_encode(array_values($usersParRole), 15, 512) ?>;

        const gridColor = 'rgba(0,0,0,0.05)';

        // === 1. Graphique activité (line) ===
        new Chart(document.getElementById('activiteChart'), {
            type: 'line',
            data: {
                labels: moisLabels,
                datasets: [{
                        label: 'Rendez-vous',
                        data: rdvData,
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99,102,241,0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#6366f1',
                        pointRadius: 5,
                    },
                    {
                        label: 'Consultations',
                        data: consultData,
                        borderColor: '#22c55e',
                        backgroundColor: 'rgba(34,197,94,0.08)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#22c55e',
                        pointRadius: 5,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: gridColor
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // === 2. Graphique statuts (doughnut) ===
        const statutColors = ['#eab308', '#22c55e', '#ef4444', '#6366f1', '#a855f7'];
        new Chart(document.getElementById('statutsChart'), {
            type: 'doughnut',
            data: {
                labels: statutLabels.length ? statutLabels : ['Aucun RDV'],
                datasets: [{
                    data: statutData.length ? statutData : [1],
                    backgroundColor: statutColors.slice(0, Math.max(statutData.length, 1)),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 15
                        }
                    }
                }
            }
        });

        // === 3. Graphique rôles (bar) ===
        const roleColors = ['#6366f1', '#22c55e', '#f97316', '#a855f7', '#14b8a6'];
        new Chart(document.getElementById('rolesChart'), {
            type: 'bar',
            data: {
                labels: roleLabels.length ? roleLabels : ['Aucun'],
                datasets: [{
                    label: 'Nombre d\'utilisateurs',
                    data: roleData.length ? roleData : [0],
                    backgroundColor: roleColors.slice(0, Math.max(roleData.length, 1)),
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: gridColor
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
<?php /**PATH C:\Users\pc\Downloads\cabinet-medical-laravel\cabinet-medical-laravel\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>