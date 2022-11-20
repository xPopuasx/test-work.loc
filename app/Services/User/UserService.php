<?php

namespace App\Services\User;

use App\Http\Filters\Api\Users\UsersFilter;
use App\Models\User\User;
use App\Services\Service;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Pavelrockjob\Filtersortpaginate\Paginate;

class UserService extends Service
{
    /**
     * @param  array  $filters
     * @param  Model|null  $parentModel
     * @return LengthAwarePaginator
     */
    public function getWithPaginate(array $filters, ?Model $parentModel): LengthAwarePaginator
    {
        return User::query()
            ->filtered(new UsersFilter())
            ->sorted()
            ->paginate(Paginate::getPerPage());
    }

    /**
     * @param  array  $request
     * @param  Model|null  $parentModel
     * @return User
     */
    public function create(array $request, ?Model $parentModel): User
    {
        return DB::transaction(function () use ($request) {
            $request['password'] = Hash::make($request['password']);
            /** @var User $user */
            $user = User::query()->create($request);

            return $user;
        });
    }

    /**
     * @param  User  $model
     * @param  array  $request
     * @return User
     *
     * @throws Exception
     */
    public function update(Model $model, array $request): User
    {
        return DB::transaction(function () use ($model, $request) {
            if (isset($request['password'])) {
                $request['password'] = Hash::make($request['password']);
            } else {
                unset($request['password']);
            }

            $model->update($request);

            (!empty($request['car_id']))
                ? $model->userCar()->updateOrCreate(['carable_id' => $model->id], ['car_id' => $request['car_id']])
                : $model->userCar()->delete();

            return $model->fresh();
        });
    }

    /**
     * @param  User  $model
     * @return bool
     */
    public function delete(Model $model): bool
    {
        $model->userCar()->delete();

        return $model->delete();
    }
}
