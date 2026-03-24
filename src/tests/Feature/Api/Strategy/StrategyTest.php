<?php

namespace Tests\Feature\Api\Strategy;

use App\Models\Strategy;
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

    public function test_can_get_strategy(): void
    {
        $strategy = Strategy::query()->create([
            'description' => 'GET strategy',
            'parameters' => ['period' => 14],
            'version' => 1,
        ]);

        $response = $this->getJson('/api/v1/strategies/' . $strategy->id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'OK',
                'data' => [
                    'id' => $strategy->id,
                    'description' => 'GET strategy',
                    'parameters' => ['period' => 14],
                    'version' => 1,
                ],
                'errors' => [],
            ]);
    }

    public function test_can_get_paginated_strategies(): void
    {
        for ($index = 1; $index <= 15; $index++) {
            Strategy::query()->create([
                'description' => 'Strategy ' . $index,
                'parameters' => ['period' => $index],
                'version' => 1,
            ]);
        }

        $response = $this->getJson('/api/v1/strategies?page=1&limit=10');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'description',
                        'parameters',
                        'version',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'meta' => [
                    'current_page',
                    'last_page',
                    'per_page',
                    'total',
                ],
                'message',
                'errors',
            ])
            ->assertJson([
                'success' => true,
                'message' => 'OK',
                'meta' => [
                    'current_page' => 1,
                    'per_page' => 10,
                    'total' => 15,
                ],
                'errors' => [],
            ]);
    }

    public function test_get_nonexistent_strategy_returns_404(): void
    {
        $response = $this->getJson('/api/v1/strategies/999999');

        $response->assertStatus(404)
            ->assertJson([
                'success' => true,
                'data' => [],
                'message' => 'Strategy not found',
                'errors' => [],
            ]);
    }

    public function test_can_update_strategy(): void
    {
        $strategy = Strategy::query()->create([
            'description' => 'Before update',
            'parameters' => ['risk' => 1],
            'version' => 1,
        ]);

        $payload = [
            'description' => 'After update',
            'parameters' => ['risk' => 2],
        ];

        $response = $this->putJson('/api/v1/strategies/' . $strategy->id, $payload);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'OK',
                'data' => [
                    'id' => $strategy->id,
                    'description' => 'After update',
                    'parameters' => ['risk' => 2],
                    'version' => 2,
                ],
                'errors' => [],
            ]);
    }

    public function test_update_nonexistent_strategy_returns_404(): void
    {
        $response = $this->putJson('/api/v1/strategies/999999', [
            'description' => 'Will fail',
        ]);

        $response->assertStatus(404)
            ->assertJson([
                'success' => true,
                'data' => [],
                'message' => 'Strategy not found',
                'errors' => [],
            ]);
    }

    public function test_update_with_partial_data(): void
    {
        $strategy = Strategy::query()->create([
            'description' => 'Partial before',
            'parameters' => ['threshold' => 10],
            'version' => 1,
        ]);

        $response = $this->putJson('/api/v1/strategies/' . $strategy->id, [
            'description' => 'Partial after',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'OK',
                'data' => [
                    'id' => $strategy->id,
                    'description' => 'Partial after',
                    'parameters' => ['threshold' => 10],
                    'version' => 2,
                ],
                'errors' => [],
            ]);
    }

    public function test_version_increments_on_update(): void
    {
        $strategy = Strategy::query()->create([
            'description' => 'Version check',
            'parameters' => ['alpha' => 1],
            'version' => 5,
        ]);

        $this->putJson('/api/v1/strategies/' . $strategy->id, [
            'description' => 'Version check updated',
        ])->assertStatus(200);

        $this->assertDatabaseHas('strategies', [
            'id' => $strategy->id,
            'version' => 6,
        ]);
    }

    public function test_can_delete_strategy(): void
    {
        $strategy = Strategy::query()->create([
            'description' => 'Delete me',
            'parameters' => ['signal' => 'sell'],
            'version' => 1,
        ]);

        $response = $this->deleteJson('/api/v1/strategies/' . $strategy->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('strategies', ['id' => $strategy->id]);
    }

    public function test_delete_nonexistent_strategy_returns_404(): void
    {
        $response = $this->deleteJson('/api/v1/strategies/999999');

        $response->assertStatus(404)
            ->assertJson([
                'success' => true,
                'data' => [],
                'message' => 'Strategy not found',
                'errors' => [],
            ]);
    }
}
