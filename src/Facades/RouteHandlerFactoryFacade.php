<?php
declare(strict_types=1);

namespace Smetaniny\ReactAdminRouting\Facades;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;

/**
 * Фасад для фабрики обработчиков маршрутов.
 *
 * @method static createHandler(Request $request) Создает обработчик маршрута на основе запроса.
 */
class RouteHandlerFactoryFacade extends Facade
{
    /**
     * Получает зарегистрированный компонент по имени.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'RouteHandlerFactory';
    }
}
