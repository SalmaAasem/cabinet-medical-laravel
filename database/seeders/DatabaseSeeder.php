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
        // ── Admin (mariam) ──
        User::create([
            'name'     => 'Administrateur',
            'email'    => 'admin@cabinet.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // ── Secrétaire (mariam) ──
        User::create([
            'name'     => 'Secrétaire',
            'email'    => 'secretaire@cabinet.com',
            'password' => Hash::make('secret123'),
            'role'     => 'secretaire',
        ]);

        // ── Admin (fatima) ──
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // ── Secrétaire (fatima) ──
        User::create([
            'name'     => 'Secretaire Fatima',
            'email'    => 'secretaire@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'secretaire',
        ]);

        // ── Médecin (fatima) ──
        $userMed = User::create([
            'name'     => 'Dr. Ahmed Rayane',
            'email'    => 'medecin@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'medecin',
        ]);
        $medecin = Medecin::create([
            'user_id'          => $userMed->id,
            'specialite'       => 'Cardiologue',
            'diplome'          => 'Doctorat en Médecine',
            'annee_experience' => 10,
        ]);

        // ── Patient (fatima) ──
        $userPat = User::create([
            'name'     => 'Salma Bennani',
            'email'    => 'patient@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'patient',
        ]);
        $patient = Patient::create([
            'user_id'   => $userPat->id,
            'telephone' => '0600000000',
        ]);

        // ── Rendez-vous (fatima) ──
        $rdv = RendezVous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_heure' => now()->subDays(2),
            'statut'     => 'confirme',
            'motif'      => 'Consultation de routine',
        ]);

        // ── Consultation (fatima) ──
        Consultation::create([
            'rendez_vous_id' => $rdv->id,
            'diagnostic'     => 'Hypertension légère détectée.',
            'traitement'     => 'Amlodipine 5mg, une fois par jour.',
            'notes'          => 'À revoir dans 3 mois.',
        ]);

        // ── Médecins + Patients seeders (mariam) ──
        $this->call([
            MedecinSeeder::class,
            PatientSeeder::class,
        ]);
    }
}