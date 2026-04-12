<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; color: #333; line-height: 1.6; }
        .container { width: 80%; margin: 20px auto; background: #ffffff; padding: 30px; border-radius: 8px; border-top: 5px solid #007bff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { color: #007bff; margin: 0; }
        .content { margin-bottom: 30px; }
        .details { background-color: #e9ecef; padding: 20px; border-radius: 5px; margin: 20px 0; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 30px; }
        .button { display: inline-block; padding: 10px 20px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Cabinet Médical</h1>
            <p>Confirmation de votre rendez-vous</p>
        </div>

        <div class="content">
            <p>Bonjour,</p>
            <p>Nous avons le plaisir de vous confirmer que votre rendez-vous a bien été enregistré dans notre cabinet.</p>
            
            <div class="details">
                <strong>🗓️ Date :</strong> {{ $appointment->date }} <br>
                <strong>👨‍⚕️ Médecin :</strong> Dr. {{ $appointment->medecin->name ?? 'Alaoui' }} <br>
                <strong>📍 Lieu :</strong> Rue Mohammed V, Casablanca
            </div>

            <p>Si vous avez besoin de modifier ou d'annuler ce rendez-vous, merci de nous contacter au moins 24 heures à l'avance.</p>
        </div>

        <div class="header">
            <a href="#" class="button">Voir mon calendrier</a>
        </div>

        <div class="footer">
            &copy; 2026 Cabinet Médical - Votre santé est notre priorité.
        </div>
    </div>
</body>
</html>