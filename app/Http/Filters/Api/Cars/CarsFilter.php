<?php

namespace App\Http\Filters\Api\Cars;

use App\Traits\Filter\FilterByIdTrait;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Pavelrockjob\Filtersortpaginate\Filter;

class CarsFilter extends Filter
{
    use FilterByIdTrait;

    public function number(Builder $builder): Builder
    {
        return $builder->where('number', 'like', $this->filters->number.'%');
    }
}
