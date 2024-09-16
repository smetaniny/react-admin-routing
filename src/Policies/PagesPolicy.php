<?php

namespace Smetaniny\ReactAdminRouting\Policies;

use Illuminate\Database\Eloquent\Model;
use Smetaniny\ReactAdminRouting\Models\UsersAdminModel;

/**
 * Политика доступа для RolesModel
 *
 * @uses \Smetaniny\ReactAdminRouting\Models\RolesModel
 */
class PagesPolicy extends AbstractPolicy
{
    /**
     * Проверяет, может ли пользователь просматривать список страниц.
     *
     * @param UsersAdminModel $user Пользователь административной панели.
     *
     * @return bool Возвращает true, если пользователь имеет доступ к просмотру, иначе false.
     */
    public function viewAny(UsersAdminModel $user): bool
    {
        return $this->canAccess($user, 'pages.list');
    }

    /**
     * Проверяет, может ли пользователь создать новую страницу.
     *
     * @param UsersAdminModel $user Пользователь административной панели.
     *
     * @return bool Возвращает true, если пользователь имеет доступ к созданию, иначе false.
 */
    public function create(UsersAdminModel $user): bool
    {
        return $this->canAccess($user, 'pages.create');
    }

    /**
     * Проверяет, может ли пользователь редактировать страницу.
     *
     * @param UsersAdminModel $user
     * @param Model $model
     *
     * @return bool
     */
    public function update(UsersAdminModel $user, Model $model): bool
    {
        return $this->canAccess($user, 'pages.edit');
    }

    /**
     * Проверяет, может ли пользователь удалить страницу.
     *
     * @param UsersAdminModel $user
     * @param Model $model
     *
     * @return bool
     */
    public function delete(UsersAdminModel $user, Model $model): bool
    {
        return $this->canAccess($user, 'pages.delete');
    }

}
