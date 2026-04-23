@extends('layouts.simple')

@section('content')
<div class="container mt-4">
    <div class="card shadow border-0 rounded-4">
        <div class="card-header bg-primary text-white p-3">
            <h4 class="mb-0">Détails de la Consultation</h4>
        </div>
        <div class="card-body p-4">
            <h5>Patient: <span class="text-muted">{{ $consultation->patient->user->name }}</span></h5>
            <hr>
            <div class="mb-3">
                <strong>Diagnostic:</strong>
                <p class="p-3 bg-light rounded">{{ $consultation->diagnostic }}</p>
            </div>
            <div class="mb-3">
                <strong>Traitement / Ordonnance:</strong>
                <p class="p-3 bg-light rounded">{{ $consultation->traitement }}</p>
            </div>
            @if($consultation->notes)
            <div class="mb-3">
                <strong>Notes:</strong>
                <p class="p-3 bg-light rounded">{{ $consultation->notes }}</p>
            </div>
            @endif
            <a href="{{ route('medecin.rendez-vous') }}" class="btn btn-secondary rounded-pill">Retour</a>
            <a href="{{ route('medecin.consultation.pdf', $consultation->id) }}" class="btn btn-danger rounded-pill">Télécharger PDF</a>
        </div>
    </div>
</div>
@endsection