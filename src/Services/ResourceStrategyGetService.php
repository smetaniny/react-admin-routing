<?php

namespace Smetaniny\ReactAdminRouting\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Smetaniny\ReactAdminRouting\Services\Contracts\QueryStrategyInterface;

/**
 * Класс `GetAllStrategy` реализует стратегию для получения всех записей из результата запроса.
 */
class ResourceStrategyGetService implements QueryStrategyInterface
{
    /**
     * Метод `execute` принимает объект запроса Builder и возвращает все записи из результата запроса.
     *
     */
    public function execute(Builder $query): Collection
    {
        return $query->get();
    }
}
