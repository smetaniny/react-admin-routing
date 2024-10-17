<?php

namespace Smetaniny\ReactAdminRouting\Console\Commands;

use Illuminate\Console\Command;
use Smetaniny\ReactAdminRouting\Models\CategoriesModel;

/**
 *  Выполняет импорт категорий в БД php artisan import:categories categories/cloth.json
 */
class ImportCategoriesCommand extends Command
{
    // Название и подпись консольной команды.
    protected $signature = 'import:categories {file=database/data/categories/cloth.json : Путь к JSON файлу}';


    // Описание консольной команды.
    protected $description = 'Импорт категорий из JSON файла в базу данных';

    /**
     * Выполнение консольной команды.
     */
    public function handle(): void
    {
        // Получение пути к файлу из аргументов команды
        $filePath = $this->argument('file');

        // Построение полного пути к файлу
        $fullPath = __DIR__ . '/../../../database/data/' . $filePath;

        // Чтение JSON файла
        if (!file_exists($fullPath)) {
            $this->error("Файл не найден: {$fullPath}");
            return;
        }

        $json = file_get_contents($fullPath);

        // Декодирование JSON в массив
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error("Ошибка декодирования JSON: " . json_last_error_msg());
            return;
        }

        // Рекурсивное сохранение категорий в базе данных
        $this->saveCategories($data);

        // Вывод сообщения об успешном импорте категорий
        $this->info('Категории успешно импортированы!');
    }

    /**
     * Сохранить категории рекурсивно.
     *
     * @param array<string, array<string>|string> $categories Ассоциативный массив категорий, где ключ — имя категории, а значение — массив подкатегорий или строка.
     * @param int|null $parentId Идентификатор родительской категории.
     */
    private function saveCategories(array $categories, int $parentId = null): void
    {
        foreach ($categories as $categoryName => $subcategories) {
            // Проверяем, является ли текущий элемент массивом или строкой
            if (is_array($subcategories)) {
                // Если это массив, то предполагаем, что он содержит подкатегории
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
