<?php

namespace Smetaniny\ReactAdminRouting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Модель для международных размеров.
 */
class InternationalSizesModel extends Model
{
    use HasFactory;

    // Имя таблицы в базе данных.
    protected $table = 'international_sizes';

    // Поля модели, которые могут быть заполнены.
    protected $fillable = [
        'size',
        'weight',
        'price',
    ];

    /**
     * Получить продукты, связанные с этим международным размером.
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(ProductsModel::class, 'international_size_id');
    }
}

