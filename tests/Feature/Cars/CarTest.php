<?php

namespace Tests\Feature\Users;

use App\Models\Car\Car;
use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

class CarTest extends TestCase
{
    public function test_create_car()
    {
        $response = $this->withHeaders($this->headers)->postJson('/api/cars', [
            'number' => (string) fake()->numberBetween(800000, 9999999),
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'number',
                    'user',
                ],
            ]);
    }

    public function test_get_car()
    {
        $response = $this->withHeaders($this->headers)->getJson('/api/cars/'.$this->getCar()->id, []);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'number',
                    'user',
                ],
            ]);
    }

    public function test_get_cars()
    {
        $response = $this->withHeaders($this->headers)->getJson('/api/cars', ['filters' => [
            'email' => $this->getCar()->number,
        ]]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'number',
                        'user',
                    ],
                ],
            ]);
    }

    public function test_update_car()
    {
        $response = $this->withHeaders($this->headers)->patchJson('/api/cars/'.$this->getCar()->id, [
            'number' => (string) fake()->numberBetween(9000000, 9999999),
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'number',
                    'user',
                ],
            ]);
    }

    public function test_delete_car()
    {
        $response = $this->withHeaders($this->headers)->deleteJson('/api/cars/'.$this->getCar()->id);

        $response->assertStatus(200);
    }

    /**
     * @return Car|null
     */
    private function getCar(): ?Model
    {
        return Car::query()->orderByDesc('id')->first() ?? null;
    }
}
