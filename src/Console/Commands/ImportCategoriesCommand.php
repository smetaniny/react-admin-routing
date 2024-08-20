<?php

namespace Smetaniny\ReactAdminRouting\Console\Commands;

use Illuminate\Console\Command;
use Smetaniny\ReactAdminRouting\Models\CategoriesModel;

class ImportCategoriesCommand extends Command
{
    /**
     * Название и подпись консольной команды.
     *
     * @var string
     */
    protected $signature = 'import:categories';

    /**
     * Описание консольной команды.
     *
     * @var string
     */
    protected $description = 'Импорт категорий из JSON файла в базу данных';

    /**
     * Выполнение консольной команды.
     */
    public function handle(): void
    {
        // Чтение JSON файла, который хранится в папке "database/data" внутри пакета
        $json = file_get_contents(__DIR__ . '/../../../database/data/categories.json');

        // Декодирование JSON в массив
        $data = json_decode($json, true);

        // Рекурсивное сохранение категорий в базе данных
        $this->saveCategories($data);

        // Вывод сообщения об успешном импорте категорий
        $this->info('Категории успешно импортированы!');
    }

    /**
     * Сохранить категории рекурсивно.
     *
     * @param array $categories
     * @param int|null $parentId
     */
    private function saveCategories(array $categories, int $parentId = null): void
    {
        foreach ($categories as $categoryName => $subcategories) {
            // Проверяем, является ли текущий элемент массивом или строкой
            if (is_array($subcategories)) {
                // Если это массив, то предполагаем, что он содержит подкатегории или строки
                $category = CategoriesModel::create([
                    'name' => $categoryName,
                    'parent_id' => $parentId,
                ]);

                // Если подкатегории — массив, рекурсивно сохраняем их
                $this->saveCategories($subcategories, $category->id);
            } else {
                // Если это строка, создаем категорию без подкатегорий
                CategoriesModel::create([
                    'name' => $subcategories,
                    'parent_id' => $parentId,
                ]);
            }
        }
    }
}
