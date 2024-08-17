<?php

namespace Smetaniny\ReactAdminRouting\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware для административных операций.
 */
class AdminMiddleware
{
    /**
     * Обработка запроса.
     *
     * @param Request $request Запрос.
     * @param Closure $next Следующий обработчик.
     *
     * @return Response Ответ.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Продолжаем выполнение запроса
        return $next($request);
    }
}

