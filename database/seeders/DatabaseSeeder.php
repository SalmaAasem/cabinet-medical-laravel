<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ──
        User::create([
            'name'     => 'Administrateur',
            'email'    => 'admin@cabinet.com',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        // ── Secrétaire ──
        User::create([
            'name'     => 'Secrétaire',
            'email'    => 'secretaire@cabinet.com',
            'password' => Hash::make('secret123'),
            'role'     => 'secretaire',
        ]);

        // ── Médecins + Patients  ──
        $this->call([
            MedecinSeeder::class,
            PatientSeeder::class,
        ]);
    }
}


