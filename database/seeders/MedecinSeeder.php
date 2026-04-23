<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Medecin;

class MedecinSeeder extends Seeder
{
    public function run()
    {
        $medecins = [
            [
                'name' => 'Dr Dupont',
                'email' => 'dupont@cabinet.com',
                'specialite' => 'Cardiologue',
                'diplome' => 'Doctorat en Médecine',
                'annee_experience' => 15,
            ],
            [
                'name' => 'Dr Martin',
                'email' => 'martin@cabinet.com',
                'specialite' => 'Dermatologue',
                'diplome' => 'Doctorat en Médecine',
                'annee_experience' => 10,
            ],
            [
                'name' => 'Dr Bernard',
                'email' => 'bernard@cabinet.com',
                'specialite' => 'Généraliste',
                'diplome' => 'Doctorat en Médecine',
                'annee_experience' => 8,
            ],
        ];

        foreach ($medecins as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('password123'),
                'role' => 'medecin',
            ]);

            Medecin::create([
                'user_id' => $user->id,
                'specialite' => $data['specialite'],
                'diplome' => $data['diplome'],
                'annee_experience' => $data['annee_experience'],
            ]);
        }
    }
}
