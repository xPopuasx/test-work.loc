<?php

namespace App\Http\Resources\Api\Car;

use App\Http\Resources\Api\User\UserResource;
use App\Models\Car\Car;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 *
 * @mixin Car
 */
class CarResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'user' => new UserResource($this->user),
        ];
    }
}
