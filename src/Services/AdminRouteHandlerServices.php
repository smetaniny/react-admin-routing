<?php
declare(strict_types=1);

namespace Smetaniny\ReactAdminRouting\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Smetaniny\ReactAdminRouting\Contracts\ResourceShowInterface;
use Smetaniny\ReactAdminRouting\Contracts\RouteHandlerInterface;
use Smetaniny\ReactAdminRouting\Exceptions\RouteHandlerAdminException;

/**
 * Обработчик маршрутов для панели администратора.
 */
class AdminRouteHandlerServices implements RouteHandlerInterface
{
    /**
     * Обрабатывает запрос для административной панели.
     *
     * @throws AdminRouteHandlerServices
     * @throws RouteHandlerAdminException
     */
    public function handle(Request $request, ?Builder $query = null, $status = 200): JsonResponse
    {
        // Получаем экземпляр интерфейса ResourceShowInterface из контейнера зависимостей
        $resourceShow = app(ResourceShowInterface::class);
        // Определение стратегии показа (множественный или единичный)
        $strategy = $request->show ?? Config::get('react-admin-routing.admin.strategy');
        // Тип запроса
        $type = $request->type ?? Config::get('react-admin-routing.admin.type');
        // Статус ответа
        $status = $status ?? Config::get('react-admin-routing.common.status');
        // Данные ответа
        $data = $request->data ?? Config::get('react-admin-routing.common.data');
        // Добавление ключа api редактора
        $data[]['tinymce-api-key'] = Config::get('react-admin-routing.tinymce-api-key');
        // Ошибки ответа
        $errors = $request->errors ?? Config::get('react-admin-routing.common.errors');

        // Если тип ресурс
        if ($type === 'resource') {
            // Если параметр '$query' не был передан, выбрасываем исключение
            if ($query === null) {
                throw new RouteHandlerAdminException('Не удалось получить модель из запроса! Не передали query!');
            }

            // Возвращаем ответ
            return $resourceShow
                // Строим запрос
                ->queryBuilder($query, $request)
                // Сортировка
                ->sort()
                // Фильтрация
                ->filter()
                // Пагинация
                ->pagination()
                // Установка стратегии запроса
                ->setQueryStrategy($strategy === 'first' ?
                    app(ResourceStrategyFirstService::class) :
                    app(ResourceStrategyGetService::class))
                // Преобразуем в JSON и возвращаем
                ->responseJson();
        }

        // Ответ по умолчанию
        return response()->json([
            // Статус ответа
            'status' => $status,
            // Данные ответа
            'data' => $data,
            // Ошибки ответа
            'errors' => $errors
        ], $status);
    }
}
