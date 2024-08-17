<?php

namespace Smetaniny\ReactAdminRouting\Contracts;

use Illuminate\Http\Request;

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
