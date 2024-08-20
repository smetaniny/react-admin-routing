<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Smetaniny\ReactAdminRouting\Enums\UserAdminRole;

Route::prefix('admin')->name('admin.')->group(function () {
    // Авторизация администратора
    Route::post('/login', [\Smetaniny\ReactAdminRouting\Controllers\LoginAdminController::class, 'index'])->name('login');

    // Проверка доступа по токену Sanctum
    Route::middleware('auth:sanctum')->group(function () {
        // Маршруты для работы со страницами сайта администратора
        Route::resource('pages', \Smetaniny\ReactAdminRouting\Controllers\PagesAdminController::class)->names('pages')
            ->middleware('role:' . UserAdminRole::ADMIN->value . ',' . UserAdminRole::EDITOR->value);

        // Маршруты для ролей с администраторами пользователей
        Route::resource('roles', \Smetaniny\ReactAdminRouting\Controllers\RolesAdminController::class)->names('roles')
            ->middleware('role:' . UserAdminRole::ADMIN->value . ',' . UserAdminRole::EDITOR->value);

        // Маршруты для работы с администраторами пользователей
        Route::resource('usersAdmin', \Smetaniny\ReactAdminRouting\Controllers\UsersAdminController::class)->names('usersAdmin')
            ->middleware('role:' . UserAdminRole::ADMIN->value . ',' . UserAdminRole::EDITOR->value);

        // Маршруты для работы с разрешениями администратора
        Route::resource('permissions', \Smetaniny\ReactAdminRouting\Controllers\PermissionsAdminController::class)->names('permissions')
            ->middleware('role:' . UserAdminRole::ADMIN->value . ',' . UserAdminRole::EDITOR->value);

        // Маршруты для работы с группами разрешений администраторов
        Route::resource('groupPermission', \Smetaniny\ReactAdminRouting\Controllers\GroupPermissionAdminController::class)->names('groupPermission')
            ->middleware('role:' . UserAdminRole::ADMIN->value . ',' . UserAdminRole::EDITOR->value);

        // Маршруты для работы с администраторами пользователей
        Route::resource('users', \Smetaniny\ReactAdminRouting\Controllers\UsersController::class)->names('users')
            ->middleware('role:' . UserAdminRole::ADMIN->value . ',' . UserAdminRole::EDITOR->value);
    });

    Route::fallback(function () {
        // Если ни один запрос не соответствует входящему
        return response()->json(['message' => 'Route not found'], 404);
    });
});
