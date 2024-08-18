<?php

declare(strict_types=1);

namespace Smetaniny\ReactAdminRouting\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Smetaniny\ReactAdminRouting\Models\UsersAdminModel;
use Smetaniny\ReactAdminRouting\Exceptions\UnauthorizedAdminException;
use Smetaniny\ReactAdminRouting\Facades\RouteHandlerFactoryFacade;
use Smetaniny\ReactAdminRouting\Requests\LoginAdminRequest;

/**
 * Контроллер для аутентификации администратора
 */
class LoginAdminController
{
    /**
     * Проверяет авторизацию администратора и выдает новый токен при необходимости.
     *
     *
     * @throws UnauthorizedAdminException
     */
    public function index(LoginAdminRequest $request): JsonResponse
    {
        // Проверяем данные аутентификации администратора
        $credentials = $request->only('email', 'password');

        // Получаем пользователя
        $admin = UsersAdminModel::where('email', $credentials['email'])->with('role.permissions')->first();

        // Проверяем пользователя
        if (!$admin || !Hash::check($request->password ?? '', $admin->password)) {
            // Возвращаем сообщение об ошибке в случае неудачной попытки аутентификации
            throw new UnauthorizedAdminException('Неудачная попытка аутентификации. Обратитесь за новым доступом в админ панель!');
        }

        // Отзыв всех токенов ...
        $admin->tokens()->delete();
        // Если нет действующих токенов, создаем новый
        $newToken = $admin->createToken('UserAdmin')->plainTextToken;

        // Проверяем данные
        if (empty($newToken) || empty($admin)) {
            // Возвращаем сообщение об ошибке в случае неудачной попытки аутентификации
            throw new UnauthorizedAdminException('Неудачная попытка аутентификации. Обратитесь за новым доступом в админ панель!');
        }

        // Создается обработчик запроса и возвращает результат выполнения
        return RouteHandlerFactoryFacade::createHandler($request)
            ->handle(
                request: $request->merge([
                    'data' => [
                        'user' => $admin,
                        'token' => $newToken,
                    ],
                ])
            );
    }
}
