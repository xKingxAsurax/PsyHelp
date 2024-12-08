<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    public function definition(): array
    {
        $psychologist = User::where('rol', 'psicólogo')->inRandomOrder()->first();
        $user = User::where('rol', 'cliente')->inRandomOrder()->first();
        
        return [
            'psychologist_id' => $psychologist->id,
            'user_id' => $user->id,
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->paragraph(),
        ];
    }
} 