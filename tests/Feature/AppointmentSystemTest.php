<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppointmentSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_schedule_appointment()
    {
        $client = User::factory()->create(['rol' => 'cliente']);
        $psychologist = User::factory()->create(['rol' => 'psicólogo']);

        $response = $this->actingAs($client)->post('/appointments', [
            'psychologist_id' => $psychologist->id,
            'date' => now()->addDays(2)->format('Y-m-d'),
            'time' => '14:00:00',
            'notes' => 'Test appointment'
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('appointments', [
            'patient_id' => $client->id,
            'psychologist_id' => $psychologist->id
        ]);
    }
} 