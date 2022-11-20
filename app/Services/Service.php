<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class Service
{
    /** Создает модель */
    abstract protected function create(array $request, ?Model $parentModel): Model;

    /** Возвращает коллекции с пагинацией */
    abstract protected function getWithPaginate(array $filters, ?Model $parentModel): LengthAwarePaginator;

    /** Обновляет модель */
    abstract protected function update(Model $model, array $request): Model;

    /** Удлакние модели */
    abstract protected function delete(Model $model): bool;
}
