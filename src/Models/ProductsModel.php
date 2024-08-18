<?php

namespace Smetaniny\ReactAdminRouting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Класс модели продуктов.
 */
class ProductsModel extends Model
{
    use HasFactory;

    // Имя таблицы в базе данных.
    protected $table = 'products';

    // Поля модели, которые могут быть заполнены.
    protected $fillable = [
        'guid',
        'article',
        'name',
        'description',
        'quantity',
        'price',
        'content_id',
        'category_id',
        'russian_size_id',
        'international_size_id',
    ];

    /**
     * Получить связанное содержимое.
     *
     * @return BelongsTo
     */
    public function content(): BelongsTo
    {
        return $this->belongsTo(ContentsModel::class, 'content_id');
    }

    /**
     * Получить категорию, к которой принадлежит продукт.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoriesModel::class, 'category_id');
    }

    /**
     * Получить российский размер продукта.
     *
     * @return BelongsTo
     */
    public function russianSize(): BelongsTo
    {
        return $this->belongsTo(RussianSizesModel::class, 'russian_size_id');
    }

    /**
     * Получить международный размер продукта.
     *
     * @return BelongsTo
     */
    public function internationalSize(): BelongsTo
    {
        return $this->belongsTo(InternationalSizesModel::class, 'international_size_id');
    }

    /**
     * Получить значения атрибутов продукта.
     *
     * @return HasMany
     */
    public function attributeValues(): HasMany
    {
        return $this->hasMany(ProductAttributeValuesModel::class, 'product_id');
    }
}
