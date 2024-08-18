<?php

namespace Smetaniny\ReactAdminRouting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Класс модели значений атрибутов продукта.
 */
class ProductAttributeValuesModel extends Model
{
    use HasFactory;

    // Имя таблицы в базе данных.
    protected $table = 'product_attribute_values';

    // Поля модели, которые могут быть заполнены.
    protected $fillable = [
        'value',
        'product_attribute_id',
        'product_id',
    ];

    /**
     * Получить атрибут продукта, к которому относится это значение атрибута.
     *
     * @return BelongsTo
     */
    public function productAttribute(): BelongsTo
    {
        return $this->belongsTo(ProductAttributesModel::class, 'product_attribute_id');
    }

    /**
     * Получить продукт, к которому относится это значение атрибута.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductsModel::class, 'product_id');
    }
}
