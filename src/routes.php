<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Smetaniny\ReactAdminRouting\Controllers\GroupPermissionAdminController;
use Smetaniny\ReactAdminRouting\Controllers\LoginAdminController;
use Smetaniny\ReactAdminRouting\Controllers\PagesAdminController;
use Smetaniny\ReactAdminRouting\Controllers\PermissionsAdminController;
use Smetaniny\ReactAdminRouting\Controllers\RolesAdminController;
use Smetaniny\ReactAdminRouting\Controllers\UsersAdminController;
use Smetaniny\ReactAdminRouting\Enums\UserAdminRole;

Route::prefix('admin')->name('admin.')->group(function () {
    // Авторизация администратора
    Route::post('/login', [LoginAdminController::class, 'index'])->name('login');

    // Проверка доступа по токену Sanctum
    Route::middleware('auth:sanctum')->group(function () {
        // Маршруты для работы со страницами сайта администратора
        Route::resource('pages', PagesAdminController::class)->names('pages')
            ->middleware('role:' . UserAdminRole::ADMIN->value . ',' . UserAdminRole::EDITOR->value);

        // Маршруты для ролей с администраторами пользователей
        Route::resource('roles', RolesAdminController::class)->names('roles')
            ->middleware('role:' . UserAdminRole::ADMIN->value . ',' . UserAdminRole::EDITOR->value);

        // Маршруты для работы с администраторами пользователей
        Route::resource('usersAdmin', UsersAdminController::class)->names('usersAdmin')
            ->middleware('role:' . UserAdminRole::ADMIN->value . ',' . UserAdminRole::EDITOR->value);

        // Маршруты для работы с разрешениями администратора
        Route::resource('permissions', PermissionsAdminController::class)->names('permissions')
            ->middleware('role:' . UserAdminRole::ADMIN->value . ',' . UserAdminRole::EDITOR->value);

        // Маршруты для работы с группами разрешений администраторов
        Route::resource('groupPermission', GroupPermissionAdminController::class)->names('groupPermission')
            ->middleware('role:' . UserAdminRole::ADMIN->value . ',' . UserAdminRole::EDITOR->value);
    });

    Route::fallback(function () {
        // Если ни один запрос не соответствует входящему
        return response()->json(['message' => 'Route not found'], 404);
    });
});
