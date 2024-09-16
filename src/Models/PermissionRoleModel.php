<?php

namespace Smetaniny\ReactAdminRouting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PermissionRoleModel extends Model
{
    protected $table = 'permission_role'; // Указываем имя таблицы

    protected $fillable = ['permission_id', 'role_id']; // Указываем поля, которые можно массово заполнять

    // Определяем связь с моделью разрешений
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(PermissionsModel::class, 'permission_id', 'role_id');
    }

    // Определяем связь с моделью ролей
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(RolesModel::class, 'role_id', 'permission_id');
    }
}
