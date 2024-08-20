<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Создание таблицы для связи разрешений и ролей.
 */
return new class extends Migration
{
    /**
     * Применение миграции.
     */
    public function up(): void
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->id(); // Первичный ключ
            // Внешний ключ, связанный с таблицей разрешений
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
            // Внешний ключ, связанный с таблицей ролей
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            // Добавление временных меток создания и обновления
            $table->timestamps();
        });

        DB::table('permission_role')->insert([
            ['permission_id' => 1, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 2, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 3, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['permission_id' => 4, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 5, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 6, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['permission_id' => 7, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 8, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 9, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['permission_id' => 10, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 11, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 12, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['permission_id' => 13, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 14, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 15, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['permission_id' => 16, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 17, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 18, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['permission_id' => 19, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 20, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 21, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['permission_id' => 22, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 23, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 24, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['permission_id' => 25, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 26, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 27, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['permission_id' => 28, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 29, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 30, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['permission_id' => 31, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 32, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 33, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['permission_id' => 34, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 35, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 36, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['permission_id' => 37, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 38, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['permission_id' => 39, 'role_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Откат миграции.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_role'); // Удаление таблицы
    }
};
