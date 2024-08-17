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
            ['name' => 'PagesList', 'description' => 'Показ страниц сайта', 'group_permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PagesCreate', 'description' => 'Создание страниц сайта', 'group_permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PagesEdit', 'description' => 'Редактирование страниц сайта', 'group_permission_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'UsersAdminList', 'description' => 'Показ списка пользователей админки', 'group_permission_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'UsersAdminCreate', 'description' => 'Создание пользователя админки', 'group_permission_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'UsersAdminEdit', 'description' => 'Редактирование пользователя админки', 'group_permission_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'CategoriesList', 'description' => 'Показ списка категорий', 'group_permission_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CategoriesCreate', 'description' => 'Создание категории', 'group_permission_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CategoriesEdit', 'description' => 'Редактирование категории', 'group_permission_id' => 3, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'ContentsList', 'description' => 'Показ списка контента', 'group_permission_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ContentsCreate', 'description' => 'Создание контента', 'group_permission_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ContentsEdit', 'description' => 'Редактирование контента', 'group_permission_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'ProductAttributesList', 'description' => 'Показ списка атрибутов продукта', 'group_permission_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ProductAttributesCreate', 'description' => 'Создание атрибута продукта', 'group_permission_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ProductAttributesEdit', 'description' => 'Редактирование атрибута продукта', 'group_permission_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'ProductAttributeValuesList', 'description' => 'Показ списка значений атрибута продукта', 'group_permission_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ProductAttributeValuesCreate', 'description' => 'Создание значения атрибута продукта', 'group_permission_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ProductAttributeValuesEdit', 'description' => 'Редактирование значения атрибута продукта', 'group_permission_id' => 6, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'ProductsList', 'description' => 'Показ списка продуктов', 'group_permission_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ProductsCreate', 'description' => 'Создание продукта', 'group_permission_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ProductsEdit', 'description' => 'Редактирование продукта', 'group_permission_id' => 7, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'RolesList', 'description' => 'Показ списка ролей', 'group_permission_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'RolesCreate', 'description' => 'Создание роли', 'group_permission_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'RolesEdit', 'description' => 'Редактирование роли', 'group_permission_id' => 8, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'PermissionRoleList', 'description' => 'Показ списка разрешений ролей', 'group_permission_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PermissionRoleCreate', 'description' => 'Создание разрешения роли', 'group_permission_id' => 9, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PermissionRoleEdit', 'description' => 'Редактирование разрешения роли', 'group_permission_id' => 9, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'PermissionsList', 'description' => 'Показ списка разрешений', 'group_permission_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PermissionsCreate', 'description' => 'Создание разрешения', 'group_permission_id' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PermissionsEdit', 'description' => 'Редактирование разрешения', 'group_permission_id' => 10, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'InternationalSizesList', 'description' => 'Показ списка международных размеров', 'group_permission_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'InternationalSizesCreate', 'description' => 'Создание международного размера', 'group_permission_id' => 11, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'InternationalSizesEdit', 'description' => 'Редактирование международного размера', 'group_permission_id' => 11, 'created_at' => now(), 'updated_at' => now()],

            ['name' => 'RussianSizesList', 'description' => 'Показ списка русских размеров', 'group_permission_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'RussianSizesCreate', 'description' => 'Создание русского размера', 'group_permission_id' => 12, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'RussianSizesEdit', 'description' => 'Редактирование русского размера', 'group_permission_id' => 12, 'created_at' => now(), 'updated_at' => now()],
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
