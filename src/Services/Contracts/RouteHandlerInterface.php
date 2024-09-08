<?php
declare(strict_types=1);

namespace Smetaniny\ReactAdminRouting\Services\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;

/**
 * Интерфейс обработчика маршрутов
 */
interface RouteHandlerInterface
{

    /**
     * Обрабатывает маршрут
     *
     * @param Request $request - объект запроса
     *
     * @return Response|JsonResponse - ответ на запрос
 */
    public function handle(Request $request, ?Builder $query, ?int $status): Response|JsonResponse;
}
