<?php

namespace Smetaniny\ReactAdminRouting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kalnoy\Nestedset\NodeTrait;

/**
 * Класс модели категорий.
 *
 */
class CategoriesModel extends Model
{
    // Использование фабрики для создания экземпляров модели.
    use HasFactory, NodeTrait;

    // Имя таблицы в базе данных.
    protected $table = 'categories';

    // Поля модели, которые могут быть заполнены.
    protected $fillable = [
        'name',
        'parent_id',
    ];


    /**
     * Получить родительскую категорию.
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(CategoriesModel::class, 'parent_id');
    }

    /**
     * Получить дочерние категории.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(CategoriesModel::class, 'parent_id');
    }

    /**
     * Получить продукты этой категории.
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(ProductsModel::class, 'category_id');
    }
}
