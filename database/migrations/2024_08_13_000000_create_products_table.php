<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
/**
 * Создание таблицы (Продукты)
 */
return new class extends Migration
{
    /**
     * Метод, который будет вызван при применении миграции
     */
    public function up(): void
    {
        // Создаем таблицу "products"
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('guid')->unique()->comment("Уникальный артикул продукта");
            $table->string('article')->unique()->comment("Уникальный артикул продукта");
            $table->string('name')->comment("Наименование продукта");
            $table->text('description')->default("")->comment("Описание продукта");
            $table->integer('quantity')->default(0)->comment("Количество доступных продуктов");
            $table->decimal('price', 10, 2)->comment("Цена продукта");

            $table->unsignedBigInteger('content_id')->comment('Внешний ключ контента');
            $table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');

            $table->unsignedBigInteger('category_id')->comment('Внешний ключ категории продукта');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->unsignedBigInteger('russian_size_id')->nullable()->comment('Внешний ключ российского размера продукта');
            $table->foreign('russian_size_id')->references('id')->on('russian_sizes')->onDelete('cascade');

            $table->unsignedBigInteger('international_size_id')->nullable()->comment('Внешний ключ международного размера продукта');
            $table->foreign('international_size_id')->references('id')->on('international_sizes')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Метод, который будет вызван при откате миграции
     */
    public function down(): void
    {
        // Удаляем таблицу "products", если она существует
        Schema::dropIfExists('products');
    }
};
