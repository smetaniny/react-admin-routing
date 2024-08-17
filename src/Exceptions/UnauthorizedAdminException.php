<?php
declare(strict_types=1);

namespace Smetaniny\ReactAdminRouting\Exceptions;

use Exception;
use Facades\RouteHandlerFactoryFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * Исключение для обработки ошибок авторизации в админ панель.
 */
class UnauthorizedAdminException extends Exception
{
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
                status: 401
            );
    }
}
