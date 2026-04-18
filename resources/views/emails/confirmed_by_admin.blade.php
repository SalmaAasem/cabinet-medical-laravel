<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; padding: 30px; border-radius: 12px; border-top: 6px solid #28a745; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { text-align: center; padding-bottom: 20px; border-bottom: 1px solid #eee; }
        .content { padding: 20px 0; }
        .info-box { background: #f0fff4; padding: 15px; border-radius: 8px; margin: 15px 0; border-left: 4px solid #28a745; color: #276749; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
        .success-icon { font-size: 48px; color: #28a745; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="success-icon">✅</div>
            <h2 style="color: #28a745;">Rendez-vous Confirmé !</h2>
        </div>
        <div class="content">
            <p>Félicitations <strong>{{ $rdv->patient->user->name }}</strong>,</p>
            <p>La secrétaire a examiné votre demande et nous sommes ravis de vous informer que votre rendez-vous est <strong>confirmé</strong>.</p>
            
            <div class="info-box">
                <p style="margin: 0;"><strong>Nous vous attendons le :</strong></p>
                <h3 style="margin: 5px 0;">{{ \Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y à H:i') }}</h3>
                <p style="margin: 0; font-size: 14px;">Cabinet Médical - Dr. {{ $rdv->medecin->user->name }}</p>
            </div>
            
            <p>Veuillez vous présenter 10 minutes avant l'heure prévue. Si vous avez un empêchement, merci de nous prévenir.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Cabinet Médical - Votre santé est notre priorité.</p>
        </div>
    </div>
</body>
</html>