<?php

namespace Tests\Security;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthorized_access_prevention()
    {
        $client = User::factory()->create(['rol' => 'cliente']);
        $psychologist = User::factory()->create(['rol' => 'psicólogo']);

        $response = $this->actingAs($client)->get('/psychologist/dashboard');
        $response->assertStatus(403);

        $response = $this->actingAs($psychologist)->get('/client/dashboard');
        $response->assertStatus(403);
    }

    public function test_sql_injection_prevention()
    {
        $response = $this->post('/login', [
            'email' => "' OR '1'='1",
            'password' => "' OR '1'='1"
        ]);

        $response->assertStatus(302);
        $this->assertGuest();
    }
} 