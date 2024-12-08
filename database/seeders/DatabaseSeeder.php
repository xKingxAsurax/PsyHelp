<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Settings;
use App\Models\Appointment;
use App\Models\Rating;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuarios
        User::factory()->count(5)->create([
            'rol' => 'psicólogo'
        ]);

        User::factory()->count(10)->create([
            'rol' => 'cliente'
        ]);

        // Crear settings para cada usuario
        User::all()->each(function ($user) {
            Settings::create([
                'user_id' => $user->id,
                'notifications_enabled' => true,
                'email_notifications' => true,
                'sms_notifications' => true,
                'language' => 'es',
                'timezone' => 'America/Bogota',
            ]);
        });

        // Crear citas
        Appointment::factory()->count(20)->create();

        // Crear calificaciones
        Rating::factory()->count(15)->create();

        // Crear roles básicos
        \DB::table('roles')->insert([
            ['nombre' => 'cliente'],
            ['nombre' => 'psicólogo'],
            ['nombre' => 'admin']
        ]);
    }
}
