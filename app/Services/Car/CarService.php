<?php

namespace App\Services\Car;

use App\Http\Filters\Api\Cars\CarsFilter;
use App\Models\Car\Car;
use App\Services\Service;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Pavelrockjob\Filtersortpaginate\Paginate;

class CarService extends Service
{
    /**
     * @param  array  $filters
     * @param  Model|null  $parentModel
     * @return LengthAwarePaginator
     */
    public function getWithPaginate(array $filters, ?Model $parentModel): LengthAwarePaginator
    {
        return Car::query()
            ->filtered(new CarsFilter())
            ->sorted()
            ->paginate(Paginate::getPerPage());
    }

    /**
     * @param  array  $request
     * @param  Model|null  $parentModel
     * @return Car
     */
    public function create(array $request, ?Model $parentModel): Car
    {
        return DB::transaction(function () use ($request) {
            return Car::query()->create($request);
        });
    }

    /**
     * @param  Car  $model
     * @param  array  $request
     * @return Car
     *
     * @throws Exception
     */
    public function update(Model $model, array $request): Car
    {
        return DB::transaction(function () use ($model, $request) {
            $model->update($request);

            return $model->fresh();
        });
    }

    /**
     * @param  Car  $model
     * @return bool
     */
    public function delete(Model $model): bool
    {
        return $model->delete();
    }
}
