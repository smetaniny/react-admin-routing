<?php

namespace Smetaniny\ReactAdminRouting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Модель для администраторов пользователей.
 * @method static where(string $string, mixed $email)
 */
class UsersAdminModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    // Имя таблицы в базе данных.
    protected $table = 'users_admin';

    //Есть автоинкремент
    public $incrementing = true;

    //Автоматом писать дату добавления и обновления
    public $timestamps = true;

    //Указываем уникальное поле таблицы
    protected $primaryKey = 'id';

    /**
     * Атрибуты, которые можно массово присваивать.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_active', 'last_login_at', 'phone', 'address', 'avatar', 'bio', 'language', 'timezone', 'social_links', 'permissions', 'custom_fields', 'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     *
     * Получить роль пользователя.
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(RolesModel::class);
    }

    /**
     *
     * Получить все роли.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(RolesModel::class, 'roles_users', 'user_admin_id', 'role_id');
    }
}
