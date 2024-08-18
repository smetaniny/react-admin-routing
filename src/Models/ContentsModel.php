<?php
declare(strict_types=1);

namespace Smetaniny\ReactAdminRouting\Models;

use App\Attributes\VarType;
use App\Attributes\VarTypeProcessor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Kalnoy\Nestedset\NodeTrait;

/**
 * Класс модели содержимого.
 */
class ContentsModel extends Model
{
    // Использование фабрики для создания экземпляров модели и мягкого удаления.
    use HasFactory;
    use NodeTrait;
    use SoftDeletes;

    // Имя таблицы в базе данных.
    protected $table = 'contents';

    #[VarType('string')]
    public string $slug;

    #[VarType('string')]
    public string $title;

    #[VarType('string')]
    public string $menu_title;

    #[VarType('int')]
    public int $menu_index;

    #[VarType('string')]
    public string $language;

    #[VarType('string')]
    public string $content_js;

    #[VarType('string')]
    public string $content;

    #[VarType('string')]
    public string $description;

    #[VarType('string')]
    public string $meta_keywords;

    #[VarType('bool')]
    public bool $is_published;

    #[VarType('bool')]
    public bool $is_visible_url;

    #[VarType('bool')]
    public bool $is_open;

    #[VarType('datetime')]
    public Carbon $published_at;

    #[VarType('datetime')]
    public Carbon $unpublished_at;

    #[VarType('string')]
    public string $canonical_url;

    #[VarType('string')]
    public string $og_title;

    #[VarType('string')]
    public string $og_description;

    #[VarType('string')]
    public string $og_image;

    #[VarType('string')]
    public string $robots;

    #[VarType('float')]
    public string $sitemap_priority;

    #[VarType('string')]
    public string $sitemap_frequency;

    #[VarType('int')]
    public int $comments_count;

    #[VarType('int')]
    public int $views_count;

    #[VarType('int')]
    public int $likes_count;

    #[VarType('int')]
    public int $shares_count;

    #[VarType('int')]
    public int $parent_id;

    #[VarType('int')]
    public int $_lft;

    #[VarType('int')]
    public int $_rgt;

    #[VarType('int')]
    public int $author_id;

    #[VarType('int')]
    public int $updated_by_id;

    // Поля модели, которые могут быть заполнены.
    protected $fillable = [
        'slug',
        'title',
        'menu_title',
        'menu_index',
        'language',
        'content_js',
        'content',
        'description',
        'meta_keywords',
        'is_published',
        'is_visible_url',
        'is_open',
        'published_at',
        'unpublished_at',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
        'robots',
        'sitemap_priority',
        'sitemap_frequency',
        'comments_count',
        'views_count',
        'likes_count',
        'shares_count',
        'parent_id',
        '_lft',
        '_rgt',
        'author_id',
        'updated_by_id'
    ];

    // Список связей, которые будут предварительно загружены с помощью Eloquent.
    protected $with = [
        'page',
        'products',
        'category',
        'russianSize',
        'internationalSize'
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            VarTypeProcessor::validate($model);
        });

        static::updating(function ($model) {
            VarTypeProcessor::validate($model);
        });
    }

    /**
     * Получить связанную страницу.
     *
     * @return HasOne
     */
    public function page(): HasOne
    {
        return $this->hasOne(PagesModel::class, 'content_id');
    }

    /**
     * Получить связанные продукты.
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(ProductsModel::class, 'content_id');
    }

    /**
     * Получить связанную категорию.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(CategoriesModel::class, 'category_id');
    }

    /**
     * Получить связанный российский размер.
     *
     * @return BelongsTo
     */
    public function russianSize(): BelongsTo
    {
        return $this->belongsTo(RussianSizesModel::class, 'russian_size_id');
    }

    /**
     * Получить связанный международный размер.
     *
     * @return BelongsTo
     */
    public function internationalSize(): BelongsTo
    {
        return $this->belongsTo(InternationalSizesModel::class, 'international_size_id');
    }
}
