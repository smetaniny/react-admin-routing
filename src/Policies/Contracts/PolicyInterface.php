<?php

namespace Smetaniny\ReactAdminRouting\Policies\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

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
     * Определяет, может ли пользователь просматривать список всех моделей.
     *
     * @param User $user Пользователь, для которого проверяется право
     * @return bool Возвращает true, если пользователь имеет право на просмотр всех моделей
     */
    public function viewAny(User $user): bool;

    /**
     * Определяет, может ли пользователь просматривать конкретную модель.
     *
     * @param User $user Пользователь, для которого проверяется право
     * @param Model $model Модель, доступ к которой проверяется
     * @return bool Возвращает true, если пользователь имеет право на просмотр этой модели
     */
    public function view(User $user, Model $model): bool;

    /**
     * Определяет, может ли пользователь создавать новую модель.
     *
     * @param User $user Пользователь, для которого проверяется право
     * @return bool Возвращает true, если пользователь имеет право на создание модели
     */
    public function create(User $user): bool;

    /**
     * Определяет, может ли пользователь обновить существующую модель.
     *
     * @param User $user Пользователь, для которого проверяется право
     * @param Model $model Модель, которую пользователь пытается обновить
     * @return bool Возвращает true, если пользователь имеет право на обновление этой модели
     */
    public function update(User $user, Model $model): bool;

    /**
     * Определяет, может ли пользователь удалить существующую модель.
     *
     * @param User $user Пользователь, для которого проверяется право
     * @param Model $model Модель, которую пользователь пытается удалить
     * @return bool Возвращает true, если пользователь имеет право на удаление этой модели
     */
    public function delete(User $user, Model $model): bool;
}
