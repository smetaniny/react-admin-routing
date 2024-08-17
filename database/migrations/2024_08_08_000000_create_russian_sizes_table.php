<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Создание таблицы (Российские размеры продуктов)
 */
return new class extends Migration
{
    /**
     * Метод, который будет вызван при применении миграции
     */
    public function up(): void
    {
        // Создаем таблицу "russian_sizes"
        Schema::create('russian_sizes', function (Blueprint $table) {
            $table->id()->comment('Уникальный идентификатор размера');
            $table->string('size')->comment('Российский размер');
            $table->decimal('weight')->default(0)->comment('Вес размера');
            $table->decimal('price', 10, 2)->comment('Цена продукта данного размера');
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
        // Удаляем таблицу "russian_sizes", если она существует
        Schema::dropIfExists('russian_sizes');
    }
};

