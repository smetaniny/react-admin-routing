<?php

namespace Smetaniny\ReactAdminRouting\Factories\Contracts;

use Illuminate\Http\Request;
use Smetaniny\ReactAdminRouting\Services\Contracts\RouteHandlerInterface;

/**
 * Интерфейс фабрики обработчиков маршрутов
 */
interface RouteHandlerFactoryInterface {

    /**
     * Создает обработчик маршрута на основе запроса
     *
     * @param Request $request - Объект запроса
     *
     * @return RouteHandlerInterface - Объект обработчика маршрута
     */
    public function createHandler(Request $request): RouteHandlerInterface;
}
