<?php

namespace Smetaniny\ReactAdminRouting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * Модель для ролей.
 */
class RolesModel extends Model
{
    use HasFactory;

    // Имя таблицы в базе данных.
    protected $table = 'roles';

    /**
     * Атрибуты, которые можно массово присваивать.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * Получить всех администраторов пользователей с этой ролью.
     *
     * @return HasMany
     */
    public function usersAdmin(): HasMany
    {
        return $this->hasMany(UsersAdminModel::class);
    }

    /**
     * Получить все разрешения этой роли.
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(PermissionsModel::class, 'permission_role', 'role_id', 'permission_id');
    }
}
