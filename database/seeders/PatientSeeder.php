<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => "Patient $i",
                'email' => "patient$i@example.com",
                'password' => bcrypt('password123'),
                'role' => 'patient',
            ]);

            Patient::create([
                'user_id' => $user->id,
                'date_naissance' => '1990-01-01',
                'telephone' => '0612345678',
                'adresse' => "$i Rue de Paris",
                'num_secu' => '123456789012345',
            ]);
        }
    }
}
