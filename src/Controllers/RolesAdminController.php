<?php
declare(strict_types=1);

namespace Smetaniny\ReactAdminRouting\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Smetaniny\ReactAdminRouting\Models\RolesModel;
use Smetaniny\ReactAdminRouting\Facades\RouteHandlerFactoryFacade;

/**
 *
 */
class RolesAdminController extends Controller
{
    /**
     * Получение ролей пользователя админ панели.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        // Создается обработчик запроса и возвращает результат выполнения
        return RouteHandlerFactoryFacade::createHandler($request)
            ->handle(
                request: $request->merge([
                    'type' => 'resource',
                ]),
                query: RolesModel::query()
                    ->with(['permissions'])
            );
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
        // Создается обработчик запроса и возвращает результат выполнения
        return RouteHandlerFactoryFacade::createHandler($request)
            ->handle(
                request: $request->merge([
                    'type' => 'resource',
                    'show' => 'first'
                ]),
                query: RolesModel::query()
                    ->findOrFail($id)
                    ->with('permissions')
            );
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
