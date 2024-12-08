<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre' => fake()->firstName(),
            'apellido' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'), // password
            'rol' => fake()->randomElement(['cliente', 'psicólogo']),
            'remember_token' => Str::random(10),
        ];
    }
}
