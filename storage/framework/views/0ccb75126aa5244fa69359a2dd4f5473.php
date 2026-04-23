<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ordonnance - <?php echo e($consultation->patient->user->name); ?></title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #667eea; padding-bottom: 20px; margin-bottom: 30px; }
        .doctor-info { float: left; text-align: left; }
        .date { float: right; }
        .clearfix { clear: both; }
        .patient-info { margin-bottom: 40px; background: #f8f9fa; padding: 15px; border-radius: 8px; }
        .content { margin-top: 50px; min-height: 300px; }
        .meds { font-size: 1.1rem; line-height: 1.8; margin-bottom: 10px; white-space: pre-line; }
        .footer { text-align: center; margin-top: 50px; font-size: 0.8rem; color: #777; border-top: 1px solid #eee; padding-top: 10px; position: absolute; bottom: 0; width: 100%; }
        .stamp { margin-top: 40px; text-align: right; font-style: italic; }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="color: #764ba2; margin-bottom: 5px;">CABINET MÉDICAL</h1>
        <p>Santé & Bien-être pour tous</p>
    </div>

    <div class="doctor-info">
        <strong>Dr. <?php echo e($consultation->medecin->user->name ?? 'Non spécifié'); ?></strong><br>
        Spécialiste en Médecine Générale<br>
        Adresse: 123 Rue Hassan II, Casablanca<br>
        Téléphone: +212 5 22 45 67 89
    </div>

    <div class="date">
        Fait le: <strong><?php echo e($consultation->created_at->format('d/m/Y')); ?></strong>
    </div>

    <div class="clearfix"></div>

    <div class="patient-info">
        <p>Patient: <strong><?php echo e($consultation->patient->user->name); ?></strong></p>
        <p>Âge: <?php echo e(\Carbon\Carbon::parse($consultation->patient->date_naissance)->age); ?> ans</p>
    </div>

    <div class="content">
        <h3 style="text-decoration: underline;">ORDONNANCE :</h3>
        <div class="meds">
            <?php echo nl2br(e($consultation->traitement)); ?>

        </div>
    </div>

    <div class="stamp">
        Signature et Cachet
    </div>

    <div class="footer">
        Cabinet Médical - 123 Rue Hassan II, Casablanca - Tél: +212 5 22 45 67 89<br>
        Email: contact@cabinet-medical.ma | Web: www.cabinetmedical.ma
    </div>
</body>
</html><?php /**PATH C:\Users\pc\Downloads\cabinet-medical-laravel\cabinet-medical-laravel\resources\views/ordonnance/pdf.blade.php ENDPATH**/ ?>