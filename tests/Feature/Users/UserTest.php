<?php

namespace Tests\Feature\Users;

use App\Models\Car\Car;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_create_user()
    {
        $response = $this->withHeaders($this->headers)->postJson('/api/users', [
            'name' => Str::random(8),
            'email' => Str::random(10).'@mail.ru',
            'password' => Str::random(10),
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'car',
                ],
            ]);
    }

    public function test_get_user()
    {
        $response = $this->withHeaders($this->headers)->getJson('/api/users/'.$this->getUser()->id, []);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'car',
                ],
            ]);
    }

    public function test_get_users()
    {
        $response = $this->withHeaders($this->headers)->getJson('/api/users', ['filters' => [
            'email' => $this->getUser()->email,
            'name' => $this->getUser()->name,
        ]]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'name',
                        'email',
                        'car',
                    ],
                ],
            ])->assertJsonCount(3);
    }

    public function test_update_user()
    {
        $response = $this->withHeaders($this->headers)->patchJson('/api/users/'.$this->getUser()->id, [
            'name' => 'update_'.Str::random(8),
            'email' => 'update_'.Str::random(10).'@mail.ru',
            'car_id' => $this->getCar()->id,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'car',
                ],
            ]);
    }

    public function test_update_user_car()
    {
        // проверка на повторное добавление выданной машины другому пользователю берём первого так как в getUser берётся последний созданый
        $response = $this->withHeaders($this->headers)->patchJson('/api/users/'.User::query()->find(1)->id, [
            'name' => 'update_'.Str::random(8),
            'email' => 'update_'.Str::random(10).'@mail.ru',
            'car_id' => $this->getCar()->id,
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'data' => [
                    'car_id',
                ],
            ]);
    }

    public function test_delete_user()
    {
        $response = $this->withHeaders($this->headers)->deleteJson('/api/users/'.$this->getUser()->id);

        $response->assertStatus(200);
    }

    /**
     * @return User|null
     */
    private function getUser(): ?Model
    {
        return User::query()->orderByDesc('id')->first() ?? null;
    }

    /**
     * @return Car|null
     */
    private function getCar(): ?Model
    {
        return Car::query()->orderByDesc('id')->first() ?? null;
    }
}
