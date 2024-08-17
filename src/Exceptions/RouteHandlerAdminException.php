<?php
declare(strict_types=1);


namespace Smetaniny\ReactAdminRouting\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Smetaniny\ReactAdminRouting\Facades\RouteHandlerFactoryFacade;

/**
 * Исключение для обработки ошибок маршрутов.
 */
class RouteHandlerAdminException extends Exception
{
    /**
     * Конструктор класса.
     *
     * @param string $message
     * @param int $status
     */
    public function __construct(string $message = "", private int $status = 500)
    {
        parent::__construct($message);
    }

    /**
     * Рендеринг исключения.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        // Создается обработчик запроса и возвращает результат выполнения
        return RouteHandlerFactoryFacade::createHandler($request)
            ->handle(
                request: $request->merge([
                    'errors' => [
                        'message' => $this->getMessage() ?: Config::get('errors.common.message'),
                        'exception' => (new \ReflectionClass($this))->getShortName(),
                    ]
                ]),
                status: $this->status
            );
    }
}
