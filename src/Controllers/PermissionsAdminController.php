<?php

namespace Smetaniny\ReactAdminRouting\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Smetaniny\ReactAdminRouting\Models\PermissionsModel;
use Smetaniny\ReactAdminRouting\Facades\RouteHandlerFactoryFacade;

/**
 * Контроллер для управления страницами права пользователей админ панели.
 */
class PermissionsAdminController extends Controller
{
    /**
     * Получение списка страниц.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        // Объединяет с запросом
        $request->merge([
            'type' => 'resource',
        ]);

        // Создается обработчик запроса и возвращает результат выполнения
        return RouteHandlerFactoryFacade::createHandler($request)
            ->handle($request, PermissionsModel::query()
                ->with('roles'));
    }

    /**
     * Отображение конкретной страницы.
     *
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function show(Request $request, string $id): JsonResponse
    {
        // Объединяет с запросом
        $request->merge([
            'type' => 'resource',
            'show' => 'first'
        ]);

        // Создается обработчик запроса и возвращает результат выполнения
        return RouteHandlerFactoryFacade::createHandler($request)
            ->handle($request, PermissionsModel::query()
                ->findOrFail($id)
                ->with('roles'));
    }

    /**
     * Отображение формы создания новой страницы.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Сохранение новой страницы.
     *
     * @param Request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Отображение формы редактирования страницы.
     *
     * @param string $id
     *
     * @return void
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Обновление данных страницы.
     *
     * @param Request $request
     * @param string $id
     *
     * @return void
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Удаление страницы.
     *
     * @param string $id
     *
     * @return void
     */
    public function destroy(string $id)
    {
        //
    }
}
