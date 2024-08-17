<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique()->comment('URL-адрес');
            $table->string('title')->comment('Заголовок');
            $table->string('menu_title')->default("")->comment('Краткий заголовок');
            $table->integer('menu_index')->default(0)->comment('Позиция в меню');
            $table->string('language')->default('en')->comment('Язык (например, "ru", "en", "fr")');
            $table->longText('content_js')->default("")->comment('Содержимое (в формате js)');
            $table->longText('content')->default("")->comment('Содержимое (в формате HTML)');
            $table->text('description')->default("")->comment('Метатег description (для SEO)');
            $table->text('meta_keywords')->default("")->comment('Метатег keywords (для SEO)');
            $table->boolean('is_published')->default(false)->comment('Флаг, указывающий, опубликована ли страница');
            $table->boolean('is_visible_url')->default(false)->comment('Флаг, указывающий, участвия в URL');
            $table->boolean('is_open')->default(false)->comment('Флаг, указывающий, открытие папки в дереве');
            $table->timestamp('published_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Дата и время публикации');
            $table->timestamp('unpublished_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Дата и время снятия с публикации');
            $table->string('canonical_url')->default("")->comment('URL-адрес канонической версии');
            $table->string('og_title')->default("")->comment('Метатег Open Graph title');
            $table->text('og_description')->default("")->comment('Метатег Open Graph description');
            $table->string('og_image')->default("")->comment('Метатег Open Graph image');
            $table->string('robots')->default('index,follow')->comment('Инструкции для поисковых роботов по индексации и индексации ссылок на странице. Например, значение noindex, nofollow запрещает индексацию и следование по ссылкам на ней');
            $table->float('sitemap_priority')->default(0.5)->comment('Приоритет в файле sitemap.xml (от 0 до 1, где 1 - наибольший приоритет)');
            $table->string('sitemap_frequency')->default('monthly')->comment('Частота обновления для поисковых роботов. Возможные значения: always, hourly, daily, weekly, monthly, yearly, never');

            $table->unsignedBigInteger('comments_count')->default(0)->comment('Количество комментариев к странице');
            $table->unsignedBigInteger('views_count')->default(0)->comment('Количество просмотров');
            $table->unsignedBigInteger('likes_count')->default(0)->comment('Количество лайков');
            $table->unsignedBigInteger('shares_count')->default(0)->comment('Количество раз, когда страница была поделена в социальных сетях или других платформах');
            $table->softDeletes()->comment('Помечены как удаленные');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('идентификатор родительской (если страница является дочерней, иначе null)');
            $table->unsignedBigInteger('_lft')->nullable()->comment('значение левой границы');
            $table->unsignedBigInteger('_rgt')->nullable()->comment('значение правой границы');
            $table->foreignId('author_id')->constrained('users_admin')->onDelete('cascade');
            $table->foreignId('updated_by_id')->constrained('users_admin')->onDelete('cascade');

            $table->timestamps();

            $table->index('slug');
            $table->index('title');
            $table->index('menu_title');
            $table->index('description');
            $table->index('meta_keywords');
            $table->index('content');
        });

        DB::table('contents')->insertGetId([
            'slug' => '/',
            'title' => 'Главная страница',
            'menu_title' => 'Главная страница',
            'menu_index' => 0,
            'language' => 'en',
            'content_js' => '<h1>Добро пожаловать на главную страницу!</h1>',
            'content' => '<h1>Добро пожаловать на главную страницу!</h1>',
            'description' => 'Описание главной страницы',
            'meta_keywords' => 'ключевые слова, главная страница',
            'is_published' => false,
            'is_visible_url' => false,
            'is_open' => false,
            'parent_id' => null,
            '_lft' => 1,
            '_rgt' => 2,
            'canonical_url' => '',
            'og_title' => 'Главная страница',
            'og_description' => 'Добро пожаловать на главную страницу!',
            'og_image' => '',
            'robots' => 'index,follow',
            'sitemap_priority' => 0.5,
            'sitemap_frequency' => 'monthly',
            'comments_count' => 0,
            'views_count' => 0,
            'likes_count' => 0,
            'shares_count' => 0,
            'author_id' => 1,
            'updated_by_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
