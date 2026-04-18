<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; padding: 30px; border-radius: 12px; border-top: 6px solid #667eea; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { text-align: center; padding-bottom: 20px; border-bottom: 1px solid #eee; }
        .content { padding: 20px 0; }
        .info-box { background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 15px 0; border-left: 4px solid #667eea; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
        .badge { background: #f0ad4e; color: white; padding: 4px 10px; border-radius: 20px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="color: #4a5568;">Demande Reçue 📩</h2>
        </div>
        <div class="content">
            <p>Bonjour <strong>{{ $rdv->patient->user->name }}</strong>,</p>
            <p>Nous avons bien reçu votre demande de rendez-vous. Actuellement, elle est <span class="badge">En attente de traitement</span>.</p>
            
            <div class="info-box">
                <p style="margin: 0;"><strong>Détails du RDV :</strong></p>
                <ul style="list-style: none; padding: 0;">
                    <li> Médecin : Dr. {{ $rdv->medecin->user->name }}</li>
                    <li> Date : {{ \Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y H:i') }}</li>
                </ul>
            </div>
            
            <p>La secrétaire va examiner votre demande et vous recevrez un email dès qu'elle sera confirmée.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Cabinet Médical - Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>