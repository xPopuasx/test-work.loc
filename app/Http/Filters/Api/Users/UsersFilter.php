<?php

namespace App\Http\Filters\Api\Users;

use App\Traits\Filter\FilterByIdTrait;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Pavelrockjob\Filtersortpaginate\Filter;

class UsersFilter extends Filter
{
    use FilterByIdTrait;

    public function email(Builder $builder): Builder
    {
        return $builder->where('email', 'like', $this->filters->email.'%');
    }

    public function name(Builder $builder): Builder
    {
        return $builder->where('name', 'like', $this->filters->name.'%');
    }
}
