<?php
declare(strict_types=1);

namespace Smetaniny\ReactAdminRouting\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Smetaniny\ReactAdminRouting\Models\PagesModel;
use Smetaniny\ReactAdminRouting\Facades\RouteHandlerFactoryFacade;

/**
 * Контроллер для управления страницами администратора.
 */
class PagesAdminController extends Controller
{
    /**
     * Получение списка страниц.
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', PagesModel::class);

        // Создается обработчик запроса и возвращает результат выполнения
        return RouteHandlerFactoryFacade::createHandler($request)
            ->handle(
                request: $request->merge([
                    'type' => 'resource',
                ]),
                query: PagesModel::query()
                    ->with('content')
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
        // Объединяем название стратегии с запросом
        $request->merge([
            'type' => 'resource',
            'show' => 'first'
        ]);

        // Создается обработчик запроса и возвращает результат выполнения
        return RouteHandlerFactoryFacade::createHandler($request)
            ->handle($request, PagesModel::query()
                ->findOrFail($id)
                ->with('content'));
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
