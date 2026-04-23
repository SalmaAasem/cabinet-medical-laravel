<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_patient_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Nadia Patient',
            'email' => 'patient@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'patient',
            'telephone' => '0612345678',
            'date_naissance' => '1995-05-20',
            'adresse' => 'Marrakech, Maroc',
        ]);

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', ['email' => 'patient@example.com', 'role' => 'patient']);

        $this->assertDatabaseHas('patients', ['telephone' => '0612345678']);

        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_new_medecin_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Dr. Ahmed',
            'email' => 'ahmed@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'medecin',
            'specialite' => 'Cardiologie',
            'diplome' => 'Doctorat en Médecine',
            'annee_experience' => 10,
        ]);

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', ['email' => 'ahmed@example.com', 'role' => 'medecin']);

        $this->assertDatabaseHas('medecins', ['specialite' => 'Cardiologie']);

        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
