<?php

namespace Smetaniny\ReactAdminRouting\Policies\Contracts;

use Illuminate\Database\Eloquent\Model;
use Smetaniny\ReactAdminRouting\Models\UsersAdminModel;

/**
 * Interface PolicyInterface
 *
 * Этот интерфейс определяет контракт для всех политик доступа в системе.
 * Любая политика, которая будет использоваться для управления правами доступа к ресурсам,
 * должна реализовать этот интерфейс.
 */
interface PolicyInterface
{
    /**
     * Определяет, может ли пользователь просматривать.
     *
     * @param UsersAdminModel $user Пользователь, для которого проверяется право
     * @return bool Возвращает true, если пользователь имеет право на просмотр всех моделей
     */
    public function viewAny(UsersAdminModel $user): bool;


    /**
     * Определяет, может ли пользователь создавать новую модель.
     *
     * @param UsersAdminModel $user Пользователь, для которого проверяется право
     * @return bool Возвращает true, если пользователь имеет право на создание модели
     */
    public function create(UsersAdminModel $user): bool;

    /**
     * Определяет, может ли пользователь обновить существующую модель.
     *
     * @param UsersAdminModel $user Пользователь, для которого проверяется право
     * @param Model $model Модель, которую пользователь пытается обновить
     * @return bool Возвращает true, если пользователь имеет право на обновление этой модели
     */
    public function update(UsersAdminModel $user, Model $model): bool;

    /**
     * Определяет, может ли пользователь удалить существующую модель.
     *
     * @param UsersAdminModel $user Пользователь, для которого проверяется право
     * @param Model $model Модель, которую пользователь пытается удалить
     * @return bool Возвращает true, если пользователь имеет право на удаление этой модели
     */
    public function delete(UsersAdminModel $user, Model $model): bool;
}
