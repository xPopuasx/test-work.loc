<?php

namespace App\Http\Resources\Api\UserCar;

use App\Http\Resources\Api\User\UserResource;
use App\Models\Car\Car;
use App\Models\UserCar;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 *
 * @mixin UserCar
 */
class UserCarResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->car->id,
            'number' => $this->car->number,
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
