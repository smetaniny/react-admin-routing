<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Создание таблицы (Атрибуты продуктов)
 */
return new class extends Migration {
    /**
     * Метод, который будет вызван при применении миграции
     */
    public function up(): void
    {
        // Создаем таблицу "product_attributes"
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment("Наименование атрибута");
            $table->index('name');
            $table->timestamps();
        });
    }

    /**
     * Метод, который будет вызван при откате миграции
     */
    public function down(): void
    {
        // Удаляем таблицу "product_attributes_table", если она существует
        Schema::dropIfExists('product_attributes');
    }
};

