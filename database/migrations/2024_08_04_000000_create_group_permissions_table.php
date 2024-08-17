<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the group_permissions table
        Schema::create('group_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Название группы разрешений');
            $table->timestamps();
        });

        // Insert data into the group_permissions table
        DB::table('group_permissions')->insert([
            ['name' => 'Страницы', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Пользователи админки', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Категории', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Контент', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Продукты', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Атрибуты продукта', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Значения атрибута продукта', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Роли', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Разрешения ролей', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Разрешения', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Международные размеры', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Русские размеры', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_permissions');
    }
};
