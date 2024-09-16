<?php

namespace Smetaniny\ReactAdminRouting\Policies;

use Smetaniny\ReactAdminRouting\Models\UsersAdminModel;
use Illuminate\Auth\Access\HandlesAuthorization;
use Smetaniny\ReactAdminRouting\Policies\Contracts\PolicyInterface;

/**
 * Абстрактный класс AbstractPolicy
 *
 * Этот класс реализует общую логику для всех политик доступа к моделям.
 *
 * Он предоставляет базовые методы проверки прав на просмотр, создание, обновление
 * и удаление моделей. Другие политики могут наследовать этот класс и
 * при необходимости переопределять методы.
 */
abstract class AbstractPolicy implements PolicyInterface
{
    use HandlesAuthorization;

    /**
     * Проверяет, имеет ли пользователь конкретное разрешение.
     *
     * @param UsersAdminModel $user
     * @param string $permission
     *
     * @return bool
     */
    protected function hasPermission(UsersAdminModel $user, string $permission): bool
    {
        // Получаем все разрешения, которые назначены пользователю через его роль
        $permissions = $user->roles->flatMap(function ($role) {
            return $role->permissions->pluck('name');
        });

        // Проверяем, содержится ли нужное разрешение в списке разрешений пользователя
        return $permissions->contains($permission);
    }

    /**
     * Общий метод для проверки, является ли пользователь администратором.
     *
     * @param UsersAdminModel $user
     *
     * @return bool
     */
    protected function isAdmin(UsersAdminModel $user): bool
    {
        return $user->roles->contains('name', 'admin');
    }

    /**
     * Проверка, имеет ли пользователь доступ к указанному ресурсу.
     *
     * @param UsersAdminModel $user
     * @param string $resource
     *
     * @return bool
     */
    public function canAccess(UsersAdminModel $user, string $resource): bool
    {
        // Если пользователь супер-админ, ему разрешены все действия
        if ($this->isAdmin($user)) {
            return true;
        }

        // Проверка конкретного права
        return $this->hasPermission($user, $resource);
    }
}

