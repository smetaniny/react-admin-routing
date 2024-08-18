<?php

namespace Smetaniny\ReactAdminRouting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Класс модели атрибутов продукта.
 */
class ProductAttributesModel extends Model
{
    use HasFactory;

    // Имя таблицы в базе данных.
    protected $table = 'product_attributes';

    // Поля модели, которые могут быть заполнены.
    protected $fillable = [
        'name',
    ];

    /**
     * Получить значения атрибута продукта.
     *
     * @return HasMany
     */
    public function attributeValues(): HasMany
    {
        return $this->hasMany(ProductAttributeValuesModel::class, 'product_attribute_id');
    }
}
