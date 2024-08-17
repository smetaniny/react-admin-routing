<?php

namespace Smetaniny\ReactAdminRouting\Factories;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Smetaniny\ReactAdminRouting\Contracts\RouteHandlerFactoryInterface;
use Smetaniny\ReactAdminRouting\Contracts\RouteHandlerInterface;
use Smetaniny\ReactAdminRouting\Exceptions\RouteHandlerException;

/**
 * Фабрика обработчиков маршрутов
 */
class RouteHandlerFactory implements RouteHandlerFactoryInterface
{
    /**
     * Создает обработчик маршрута на основе запроса
     *
     * @param Request $request - Объект запроса
     *
     * @return RouteHandlerInterface - Объект обработчика маршрута
     * @throws RouteHandlerException - Исключение, если обработчик маршрута не может быть создан
     */
    public function createHandler(Request $request): RouteHandlerInterface
    {
        // Возвращаем обработчик маршрута в зависимости от условий
        return match (true) {
            // Если имя маршрута содержит '.admin'
            str_contains(Route::currentRouteName(), 'admin') => app(AdminRouteHandlerFactory::class)->createHandler($request),
            // По умолчанию выбрасываем исключение с сообщением об ошибке
            default => throw new RouteHandlerException(),
        };
    }
}
