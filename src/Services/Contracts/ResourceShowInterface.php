<?php

namespace Smetaniny\ReactAdminRouting\Services\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface ResourceShowInterface extends QueryStrategyInterface, SetQueryStrategyInterface
{
    /**
     * Настройка объекта
     *
     * @param Builder $query - Экземпляр запроса Builder
     * @param Request $request - Экземпляр запроса HTTP Request
     *
     * @return $this
     */
    public function queryBuilder(Builder $query, Request $request): self;

    /**
     * Изменение Builder
     *
     * @param Builder $query
     *
     * @return $this
     */
    public function setQuery(Builder $query): self;

    /**
     * Вычисление количества результатов
     *
     * @return $this
     */
    public function count(): self;

    /**
     * Сортировка
     *
     * @return $this
     */
    public function sort(): self;

    /**
     * Фильтрация
     *
     * @return $this
     */
    public function filter(): self;

    /**
     * Пагинация
     *
     * @return $this
     */
    public function pagination(): self;

    /**
     * Получение результата Json
     *
     * @param array $apiHeaders - Передача api ключей на клиент
     *
     * @return JsonResponse
     */
    public function responseJson() : JsonResponse;

    /**
     *  Получение результата
     *
     * @return mixed
     */
    public function response(): mixed;
}
