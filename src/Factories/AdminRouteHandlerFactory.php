<?php

namespace Smetaniny\ReactAdminRouting\Factories;

use Illuminate\Http\Request;
use Smetaniny\ReactAdminRouting\Factories\Contracts\RouteHandlerFactoryInterface;
use Smetaniny\ReactAdminRouting\Services\AdminRouteHandlerServices;

/**
 * Фабрика обработчиков маршрутов для административных функций
 */
class AdminRouteHandlerFactory implements RouteHandlerFactoryInterface {

    /**
     * Создает обработчик маршрута для административных функций
     *
     * @param Request $request - Объект запроса
     *
     * @return AdminRouteHandlerServices Объект обработчика маршрута
     */
    public function createHandler(Request $request): AdminRouteHandlerServices
    {
        // Создаем и возвращаем обработчик маршрута
        return new AdminRouteHandlerServices();
    }
}
