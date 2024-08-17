<?php

namespace Smetaniny\ReactAdminRouting\Contracts;

use Illuminate\Database\Eloquent\Builder;

/**
 * Интерфейс `QueryStrategy` определяет контракт для классов-стратегий.
 */
interface QueryStrategyInterface
{
    /**
     * Метод `execute` принимает объект запроса Builder и возвращает результат выполнения запроса.
     *
     * @param Builder $query
     *
     * @return mixed
     */
    public function execute(Builder $query): mixed;
}

