<?php

namespace Smetaniny\ReactAdminRouting\Services;

use Illuminate\Database\Eloquent\Builder;
use Smetaniny\ReactAdminRouting\Services\Contracts\QueryStrategyInterface;

/**
 * Класс `GetFirstStrategy` реализует стратегию для получения первой записи из результата запроса.
 */
class ResourceStrategyFirstService implements QueryStrategyInterface
{
    /**
     * Метод `execute` принимает объект запроса Builder и возвращает первую запись из результата запроса.
     *
     * @param Builder $query
     *
     * @return object|null
     */
    public function execute(Builder $query): null|object
    {
        return $query->first();
    }
}
