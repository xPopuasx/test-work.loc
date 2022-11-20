<?php

namespace App\Traits\Filter;

use Illuminate\Contracts\Database\Eloquent\Builder;

trait FilterByIdTrait
{
    public function id(Builder $builder): Builder
    {
        return $builder->where('id', $this->filters->id);
    }
}
