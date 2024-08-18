<?php
declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Название права');
            $table->string('description')->comment('Описание права');
            $table->unsignedBigInteger('group_permission_id')->default(1)->comment('Идентификатор группы ролей');

            // Add the foreign key constraint
            $table->foreign('group_permission_id')->references('id')->on('group_permissions')->onDelete('cascade');
            $table->index('group_permission_id');
            $table->timestamps();
        });

        // Insert data into the permissions table
        DB::table('permissions')->insert([
            ['name' => 'pages.list', 'description' => 'Показ страниц сайта', 'group_permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'pages.create', 'description' => 'Создание страниц сайта', 'group_permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'pages.edit', 'description' => 'Редактирование страниц сайта', 'group_permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'users.admin.list', 'description' => 'Показ списка пользователей админки', 'group_permission_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'users.admin.create', 'description' => 'Создание пользователя админки', 'group_permission_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'users.admin.edit', 'description' => 'Редактирование пользователя админки', 'group_permission_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'categories.list', 'description' => 'Показ списка категорий', 'group_permission_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'categories.create', 'description' => 'Создание категории', 'group_permission_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'categories.edit', 'description' => 'Редактирование категории', 'group_permission_id' => 3, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'contents.list', 'description' => 'Показ списка контента', 'group_permission_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'contents.create', 'description' => 'Создание контента', 'group_permission_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'contents.edit', 'description' => 'Редактирование контента', 'group_permission_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'product.attributes.list', 'description' => 'Показ списка атрибутов продукта', 'group_permission_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'product.attributes.create', 'description' => 'Создание атрибута продукта', 'group_permission_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'product.attributes.edit', 'description' => 'Редактирование атрибута продукта', 'group_permission_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'product.attribute.values.list', 'description' => 'Показ списка значений атрибута продукта', 'group_permission_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'product.attribute.values.create', 'description' => 'Создание значения атрибута продукта', 'group_permission_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'product.attribute.values.edit', 'description' => 'Редактирование значения атрибута продукта', 'group_permission_id' => 6, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'products.list', 'description' => 'Показ списка продуктов', 'group_permission_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'products.create', 'description' => 'Создание продукта', 'group_permission_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'products.edit', 'description' => 'Редактирование продукта', 'group_permission_id' => 7, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'roles.list', 'description' => 'Показ списка ролей', 'group_permission_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'roles.create', 'description' => 'Создание роли', 'group_permission_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'roles.edit', 'description' => 'Редактирование роли', 'group_permission_id' => 8, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'permission.role.list', 'description' => 'Показ списка разрешений ролей', 'group_permission_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'permission.role.create', 'description' => 'Создание разрешения роли', 'group_permission_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'permission.role.edit', 'description' => 'Редактирование разрешения роли', 'group_permission_id' => 9, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'permissions.list', 'description' => 'Показ списка разрешений', 'group_permission_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'permissions.create', 'description' => 'Создание разрешения', 'group_permission_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'permissions.edit', 'description' => 'Редактирование разрешения', 'group_permission_id' => 10, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'international.sizes.list', 'description' => 'Показ списка международных размеров', 'group_permission_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'international.sizes.create', 'description' => 'Создание международного размера', 'group_permission_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'international.sizes.edit', 'description' => 'Редактирование международного размера', 'group_permission_id' => 11, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'russian.sizes.list', 'description' => 'Показ списка русских размеров', 'group_permission_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'russian.sizes.create', 'description' => 'Создание русского размера', 'group_permission_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'russian.sizes.edit', 'description' => 'Редактирование русского размера', 'group_permission_id' => 12, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
