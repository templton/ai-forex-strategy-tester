<?php

namespace Tests\Feature\Api\Strategy;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StrategyTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_strategy(): void
    {
        $payload = [
            'description' => 'Test strategy',
            'parameters' => ['key' => 'value'],
        ];

        $response = $this->postJson('/api/v1/strategies', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'description',
                    'parameters',
                    'version',
                    'createdAt',
                    'updatedAt',
                ],
                'message',
                'errors',
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Strategy created successfully',
                'data' => [
                    'description' => 'Test strategy',
                    'parameters' => ['key' => 'value'],
                    'version' => 1,
                ],
            ]);

        $this->assertDatabaseHas('strategies', [
            'description' => 'Test strategy',
            'version' => 1,
        ]);
    }

    public function test_validation_fails(): void
    {
        $response = $this->postJson('/api/v1/strategies', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['description', 'parameters']);
    }
}
