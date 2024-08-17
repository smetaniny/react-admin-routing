<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Создание таблицы (Международные размеры продуктов)
 */
return new class extends Migration
{
    /**
     * Метод, который будет вызван при применении миграции
     */
    public function up(): void
    {
        // Создаем таблицу "international_sizes"
        Schema::create('international_sizes', function (Blueprint $table) {
            $table->id()->comment('Уникальный идентификатор размера');
            $table->string('size')->comment('Международный размер');
            $table->decimal('weight')->default(0)->comment('Вес размера');
            $table->decimal('price', 10, 2)->default(0)->comment('Цена продукта данного размера');
            $table->timestamps();
            $table->index('size');
            $table->index('weight');
        });
    }

    /**
     * Метод, который будет вызван при откате миграции
     */
    public function down(): void
    {
        // Удаляем таблицу "international_sizes", если она существует
        Schema::dropIfExists('international_sizes');
    }
};
