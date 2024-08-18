<?php

namespace Smetaniny\ReactAdminRouting\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Класс модели страниц.
 */
class PagesModel extends Model
{
    // Использование фабрики для создания экземпляров модели.
    use HasFactory;

    // Имя таблицы в базе данных.
    protected $table = 'pages';

    // Поля модели, которые могут быть заполнены.
    protected $fillable = [
        'content_id'
    ];

    /**
     * Получить связанное содержимое.
     *
     * @return BelongsTo
     */
    public function content(): BelongsTo
    {
        return $this->belongsTo(ContentsModel::class);
    }

    /**
     * Получить продукт, связанный с этой страницей.
     *
     * @return HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(ProductsModel::class, 'page_id');
    }
}
