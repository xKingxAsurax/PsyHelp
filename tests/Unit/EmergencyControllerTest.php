<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Emergency;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmergencyControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_emergency()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)->post('/emergency/request', [
            'description' => 'Test emergency',
            'location' => json_encode(['latitude' => 40.7128, 'longitude' => -74.0060])
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('emergencies', [
            'user_id' => $user->id,
            'status' => 'pending'
        ]);
    }

    public function test_emergency_requires_authentication()
    {
        $response = $this->post('/emergency/request', [
            'description' => 'Test emergency'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
} 