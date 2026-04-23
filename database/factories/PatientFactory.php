<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array {
    return [
        'user_id' => \App\Models\User::factory(),
        'num_secu' => fake()->numerify('#############'),
        'adresse' => fake()->address(),
        'telephone' => '06' . fake()->numerify('########'),
        'date_naissance' => fake()->date('Y-m-d', '2000-01-01'),
    ];
}
}
