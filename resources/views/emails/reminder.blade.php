<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; color: #333; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; padding: 25px; border-radius: 10px; border-top: 5px solid #17a2b8; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { text-align: center; color: #17a2b8; }
        .info-box { background: #e9ecef; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .footer { font-size: 12px; color: #777; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Rappel de Rendez-vous ⏰</h2>
        </div>
        <div class="content">
            <p>Bonjour <strong>{{ $rdv->patient->user->name }}</strong>,</p>
            <p>Ceci est un petit rappel pour votre rendez-vous prévu pour <strong>demain</strong>.</p>
            
            <div class="info-box">
                <p><strong>Détails :</strong></p>
                <ul>
                    <li>👨‍⚕️ Médecin : Dr. {{ $rdv->medecin->user->name }}</li>
                    <li>🕒 Heure : {{ \Carbon\Carbon::parse($rdv->date_heure)->format('H:i') }}</li>
                </ul>
            </div>
            
            <p>Nous avons hâte de vous voir. Si vous ne pouvez pas venir, merci de nous contacter au plus vite.</p>
        </div>
        <div class="footer">
            <p>Ceci est un message automatique, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>