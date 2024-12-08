<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        $patient = User::where('rol', 'cliente')->inRandomOrder()->first();
        $psychologist = User::where('rol', 'psicólogo')->inRandomOrder()->first();
        
        return [
            'patient_id' => $patient->id,
            'psychologist_id' => $psychologist->id,
            'date' => fake()->dateTimeBetween('now', '+2 months'),
            'time' => fake()->time('H:i'),
            'duration' => fake()->randomElement([30, 45, 60]),
            'type' => fake()->randomElement(['primera_vez', 'seguimiento', 'emergencia']),
            'status' => fake()->randomElement(['programada', 'completada', 'cancelada']),
            'meeting_link' => fake()->url(),
            'notes' => fake()->text(200),
        ];
    }
} 