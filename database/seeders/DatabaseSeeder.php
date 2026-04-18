<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\RendezVous;
use App\Models\Consultation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. إنشاء Secretaire
        User::create([
            'name' => 'Secretaire Fatima',
            'email' => 'secretaire@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'secretaire',
        ]);

        // 3. إنشاء Medecin
        $userMed = User::create([
            'name' => 'Dr. Ahmed Rayane',
            'email' => 'medecin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'medecin',
        ]);
        $medecin = Medecin::create([
            'user_id' => $userMed->id,
            'specialite' => 'Cardiologue',
            'diplome' => 'Doctorat en Médecine',
            'annee_experience' => 10,
        ]);

        // 4. إنشاء Patient
        $userPat = User::create([
            'name' => 'Salma Bennani',
            'email' => 'patient@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);
        $patient = Patient::create([
            'user_id' => $userPat->id,
            'telephone' => '0600000000',
        ]);

        // 5. إنشاء Rendez-vous (موعد قديم باش نديرو ليه استشارة)
        $rdv = RendezVous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_heure' => now()->subDays(2), // موعد قبل يومين
            'statut' => 'confirme',
            'motif' => 'Consultation de routine',
        ]);

        // 6. إنشاء Consultation (التاريخ الطبي)
        Consultation::create([
            'rendez_vous_id' => $rdv->id,
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'diagnostic' => 'Hypertension légère détectée.',
            'traitement' => 'Amlodipine 5mg, une fois par jour.',
            'notes' => 'À revoir dans 3 mois.',
        ]);
    }
}