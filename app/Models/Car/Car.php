<?php

namespace App\Models\Car;

use App\Models\User\User;
use App\Models\UserCar;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pavelrockjob\Filtersortpaginate\Traits\Filtrable;
use Pavelrockjob\Filtersortpaginate\Traits\Sortable;

/**
 * @property int $id
 * @property string $number
 * @property UserCar|null $tenant
 * @property User|null $user
 */
class Car extends Model
{
    use HasFactory, Filtrable, Sortable, SoftDeletes;

    protected $fillable = [
        'number',
    ];

    public $casts = [
        'user',
    ];

    public function tenant(): hasOne
    {
        return $this->hasOne(UserCar::class);
    }

    protected function user(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->tenant?->user,
        );
    }
}
