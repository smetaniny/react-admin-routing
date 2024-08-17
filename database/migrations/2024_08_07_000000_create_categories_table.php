<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Категории для продукта
 */
return new class extends Migration
{
    /**
     * Метод, который будет вызван при применении миграции
     */
    public function up(): void
    {
        // Создаем таблицу "categories"
        Schema::create('categories', function (Blueprint $table) {
            $table->id()->comment('Уникальный идентификатор');
            $table->string('name')->comment('Наименование категории');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('ID родительской категории');
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();

            $table->index('name');
        });
    }

    /**
     * Метод, который будет вызван при откате миграции
     */
    public function down(): void
    {
        // Удаляем таблицу "categories", если она существует
        Schema::dropIfExists('categories');
    }
};
