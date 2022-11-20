<?php

namespace App\Http\Resources\Api\User;

use App\Http\Resources\Api\UserCar\UserCarResource;
use App\Models\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 *
 * @mixin User
 */
class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'car' => new UserCarResource($this->whenLoaded('userCar')),
        ];
    }
}
