<?php

namespace App\Models;

use App\Models\Car\Car;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;


/**
 * @property int $carable_id
 * @property string $carable_type
 * @property int $file_id
 * @property Car|null $car
 * @property User|null $user
 */
class UserCar extends Model
{
    use HasFactory;

    protected $fillable = [
        'carable_id',
        'carable_type',
        'car_id',
    ];

    public function carable(): MorphTo
    {
        return $this->morphTo();
    }

    public function car(): belongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class, 'carable_id');
    }

}
