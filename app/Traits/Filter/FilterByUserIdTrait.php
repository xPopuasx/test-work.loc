<?php

namespace App\Traits\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;

trait FilterByUserIdTrait
{
    public function user_id(Builder $builder): Builder
    {
        return $builder->where('user_id', $this->filters->user_id);
    }
}
