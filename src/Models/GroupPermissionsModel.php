<?php
declare(strict_types=1);

namespace Smetaniny\ReactAdminRouting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Модель для работы с таблицей group_permission.
 */
class GroupPermissionsModel extends Model
{
    use HasFactory;

    // Имя таблицы в базе данных.
    protected $table = 'group_permissions';

    /**
     * Атрибуты, которые можно массово присваивать.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Отношение "один ко многим" с моделью Permissions.
     *
     * @return HasMany
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(PermissionsModel::class, 'group_permission_id');
    }
}
