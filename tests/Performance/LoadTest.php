<?php

namespace Tests\Performance;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class LoadTest extends TestCase
{
    use WithoutMiddleware;

    public function test_homepage_load_time()
    {
        $startTime = microtime(true);
        
        $response = $this->get('/');
        
        $endTime = microtime(true);
        $loadTime = ($endTime - $startTime) * 1000; // en milisegundos

        $response->assertStatus(200);
        $this->assertLessThan(500, $loadTime, 'La página tarda más de 500ms en cargar');
    }

    public function test_concurrent_emergency_requests()
    {
        $users = User::factory()->count(10)->create();
        $startTime = microtime(true);
        
        foreach ($users as $user) {
            $this->actingAs($user)->post('/emergency/request', [
                'description' => 'Concurrent test emergency'
            ]);
        }
        
        $endTime = microtime(true);
        $totalTime = ($endTime - $startTime) * 1000;
        
        $this->assertLessThan(2000, $totalTime, 'Las solicitudes concurrentes tardan más de 2 segundos');
    }
} 