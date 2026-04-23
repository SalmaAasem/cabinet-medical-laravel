<?php

namespace Database\Factories;

use App\Models\Medecin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Medecin>
 */
class MedecinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array {
    return [
        'user_id' => \App\Models\User::factory(),
        'specialite' => fake()->randomElement(['Cardiologue', 'Généraliste', 'Dermatologue']),
        'diplome' => 'Doctorat en Médecine',
        'annee_experience' => fake()->numberBetween(1, 20),
    ];
}
}
