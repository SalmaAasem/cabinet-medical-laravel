<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ordonnance</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 50px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #2c3e50;
        }
        .medecin {
            margin-bottom: 30px;
        }
        .patient {
            margin-bottom: 30px;
            padding: 10px;
            background: #f5f5f5;
        }
        .ordonnance {
            margin: 30px 0;
            border: 1px dashed #333;
            padding: 20px;
            min-height: 200px;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }
        .signature {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Cabinet Médical</h1>
        <p>Centre de soins et consultations</p>
    </div>
    
    <div class="medecin">
        <strong>Dr. {{ $consultation->rendezVous->medecin->user->name }}</strong><br>
        Spécialité: {{ $consultation->rendezVous->medecin->specialite }}<br>
        Diplôme: {{ $consultation->rendezVous->medecin->diplome }}
    </div>
    
    <div class="patient">
        <strong>Patient :</strong> {{ $consultation->rendezVous->patient->user->name }}<br>
        <strong>Date de consultation :</strong> {{ $consultation->created_at->format('d/m/Y') }}<br>
        <strong>Rendez-vous du :</strong> {{ \Carbon\Carbon::parse($consultation->rendezVous->date_heure)->format('d/m/Y H:i') }}
    </div>
    
    <div class="ordonnance">
        <h3>🩺 Diagnostic</h3>
        <p>{{ $consultation->diagnostic }}</p>
        
        <h3>💊 Prescription / Traitement</h3>
        <p>{{ $consultation->traitement }}</p>
        
        @if($consultation->notes)
            <h3>📝 Notes supplémentaires</h3>
            <p>{{ $consultation->notes }}</p>
        @endif
    </div>
    
    <div class="footer">
        <p>À renouveler si nécessaire. Durée du traitement: à déterminer par le médecin.</p>
        <div class="signature">
            Signature du médecin : _________________
        </div>
      <small>Document généré par Cabinet Médical - {{ now()->format('d/m/Y H:i') }}</small>
    </div>
</body>
</html>