<?php

namespace Smetaniny\ReactAdminRouting\Exceptions;

use App\Exceptions\Handler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use Throwable;
use Illuminate\Http\Response;

/**
 * Класс обработки исключений
 */
class HandleReactAdmin extends Handler
{
    /**
     * @var string[] Список полей, которые не должны отображаться в случае ошибки
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Регистрация коллбэков для отчетности об исключениях
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // Здесь можно добавить логику для отчетности об исключениях
        });
    }

    /**
     * Обработка рендеринга исключений
     *
     * @param $request - Запрос
     * @param Throwable $e - Исключение
     *
     * @return JsonResponse|Response JSON-ответ с информацией об ошибке
     * @throws Throwable
     */
    public function render($request, Throwable $e): JsonResponse|Response
    {
        $parent = parent::render($request, $e);

        return response()->json([
            "status" => $parent->status(),
            "data" => [],
            'errors' => [
                'message' => $e->getMessage() ?: Config::get('errors.common.message'),
                'exception' => (new \ReflectionClass($e))->getShortName(),
                'trace' => config('app.debug') ? $e->getTrace() : [],
            ],
        ], $parent->status());
    }

}
