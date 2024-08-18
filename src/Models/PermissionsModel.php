<?php
declare(strict_types=1);

namespace Smetaniny\ReactAdminRouting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Модель для разрешений.
 */
class PermissionsModel extends Model
{
    use HasFactory;

    // Имя таблицы в базе данных.
    protected $table = 'permissions';

    /**
     * Атрибуты, которые можно массово присваивать.
     *
     * @var array
     */
    protected $fillable = [
        'name' // Название права
    ];

    /**
     * Получить все роли, связанные с этим разрешением.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(RolesModel::class, 'permission_role', 'permission_id', 'role_id');
    }

    /**
     * Получить группу разрешений, к которой принадлежит данное разрешение.
     *
     * @return BelongsTo
     */
    public function groupPermission(): BelongsTo
    {
        return $this->belongsTo(GroupPermissionsModel::class);
    }
}
