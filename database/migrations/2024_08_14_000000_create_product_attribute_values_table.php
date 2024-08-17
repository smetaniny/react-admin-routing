<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Создание таблицы (Значения атрибутов продуктов)
 */
return new class extends Migration {
    /**
     * Метод, который будет вызван при применении миграции
     */
    public function up(): void
    {
        // Создаем таблицу "product_attribute_values"
        Schema::create('product_attribute_values', function (Blueprint $table) {
            $table->id();
            $table->string('value')->comment("Значение атрибута");
            $table->unsignedBigInteger('product_attribute_id')->comment("Внешний ключ, связывающий значение атрибута с атрибутом продукта");
            $table->unsignedBigInteger('product_id')->comment("Внешний ключ, связывающий значение атрибута с продуктом");
            $table->foreign('product_attribute_id')->references('id')->on('product_attributes')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->index('value');
            $table->timestamps();
        });
    }

    /**
     * Метод, который будет вызван при откате миграции
     */
    public function down(): void
    {
        // Удаляем таблицу "product_attribute_values", если она существует
        Schema::dropIfExists('product_attribute_values');
    }
};

