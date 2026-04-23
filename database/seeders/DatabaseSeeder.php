<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Medecin;
use App\Models\RendezVous;
use App\Models\Consultation;
use App\Models\Planning;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@cabinet.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Secretaire Fatima',
            'email' => 'secretaire@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'secretaire',
        ]);

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

        $jours = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        foreach ($jours as $jour) {
            Planning::create([
                'medecin_id' => $medecin->id,
                'jour' => $jour,
                'heure_debut' => '09:00:00',
                'heure_fin' => '17:00:00',
                'duree_consultation' => 30,
            ]);
        }

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

        $rdv = RendezVous::create([
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'date_heure' => now()->addDays(1),
            'date_rdv' => now()->addDays(1)->format('Y-m-d'),
            'heure_rdv' => '10:00',
            'statut' => 'confirme',
            'motif' => 'Consultation de routine',
        ]);

        Consultation::create([
            'rendez_vous_id' => $rdv->id,
            'patient_id' => $patient->id,
            'medecin_id' => $medecin->id,
            'diagnostic' => 'Hypertension légère détectée.',
            'traitement' => 'Amlodipine 5mg, une fois par jour.',
            'notes' => 'À revoir dans 3 mois.',
        ]);

        $this->call([MedecinSeeder::class, PatientSeeder::class]);
    }
}
