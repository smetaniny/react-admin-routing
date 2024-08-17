<?php

namespace Smetaniny\ReactAdminRouting\Exceptions;


use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Исключение для обработки ошибок маршрутов.
 */
class RouteHandlerException extends Exception
{
    // Рендеринг исключения.
    public function render(): Response
    {
        // Возвращаем шаблон страницы 500 с данными для отображения
        return Inertia::render("500", [
            'user' => Auth::user(),
            'errors' => Config::get('errors.common.message') . " Код ошибки " . Config::get('errors.404.1.code'),
        ]);
    }

}
