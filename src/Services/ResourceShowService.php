<?php
declare(strict_types=1);

namespace Smetaniny\ReactAdminRouting\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Smetaniny\ReactAdminRouting\Contracts\QueryStrategyInterface;
use Smetaniny\ReactAdminRouting\Contracts\ResourceShowInterface;
use WeakMap;

/**
 * Сервис для отображения списка ресурсов.
 *
 * Этот класс управляет получением, фильтрацией, сортировкой и пагинацией ресурсов.
 * Он реализует интерфейс ResourceShowInterface, который предоставляется в пакете
 * Resources. Пакет Resources включает в себя компоненты и сервисы, предназначенные
 * для работы с различными ресурсами приложения, такими как доступ к данным, их
 * обработка и представление.
 *
 * @package App\Services\Resources
 */
class ResourceShowService implements ResourceShowInterface
{
    /**
     * Экземпляр запроса Builder для работы с базой данных.
     *
     * @var WeakMap<int, \Illuminate\Database\Query\Builder>
     */
    private static WeakMap $queryMap;

    /**
     * Экземпляр запроса HTTP Request для доступа к данным запроса.
     *
     * @var WeakMap<int, Request>
     */
    private static WeakMap $requestMap;

    /**
     * Стратегия для выполнения запросов.
     *
     * @var QueryStrategyInterface
     */
    private QueryStrategyInterface $queryStrategy;

    /**
     * Начальная позиция для пагинации.
     *
     * @var int
     */
    protected int $start = 0;

    /**
     * Конечная позиция для пагинации.
     *
     * @var int
     */
    protected int $end = 0;

    /**
     * Количество результатов.
     *
     * @var int
     */
    protected int $count = 0;

    /**
     * Массив значений сортировки (_order и _sort).
     *
     * @var array<string, mixed>
     */
    protected array $sort = [];

    /**
     * Массив параметров пагинации (_start и _end).
     *
     * @var array<string, int>
     */
    protected array $pagination = [];

    /**
     * Массив параметров фильтрации.
     *
     * @var array<string, mixed>
     */
    protected array $filter = [];

    /**
     * Мета-данные для обработки запросов.
     *
     * @var WeakMap<int, mixed>
     */
    private static WeakMap $metadata;

    /**
     * Конструктор класса ResourceShowService.
     *
     * Инициализирует стратегию запроса и создаёт необходимые WeakMap для хранения
     * запросов и мета-данных.
     *
     * @param ResourceStrategyGetService $getAllStrategy Стратегия для получения всех ресурсов.
     */
    public function __construct(ResourceStrategyGetService $getAllStrategy)
    {
        // Устанавливаем стратегию запроса, которая будет использоваться для получения ресурсов.
        // Переданный параметр $getAllStrategy должен реализовывать интерфейс ResourceStrategyInterface.
        $this->setQueryStrategy($getAllStrategy);

        // Проверяем, инициализирована ли уже WeakMap для запросов к базе данных.
        if (!isset(self::$queryMap)) {
            // Если нет, создаём новый экземпляр WeakMap для хранения объектов Builder.
            self::$queryMap = new \WeakMap();
        }

        // Проверяем, инициализирована ли уже WeakMap для HTTP запросов.
        if (!isset(self::$requestMap)) {
            // Если нет, создаём новый экземпляр WeakMap для хранения объектов Request.
            self::$requestMap = new \WeakMap();
        }
    }

    /**
     * Получение экземпляра запроса Builder из WeakMap.
     *
     * Извлекает текущий экземпляр запроса `Builder`, сохранённый в `WeakMap` для данного объекта.
     *
     * @return Builder Экземпляр запроса Builder.
     */
    private function getQuery(): Builder
    {
        // Возвращаем экземпляр запроса Builder из WeakMap.
        return self::$queryMap[$this];
    }

    /**
     * Получение экземпляра запроса HTTP Request из WeakMap.
     *
     * Извлекает текущий экземпляр запроса HTTP Request, сохранённый в `WeakMap` для данного объекта.
     *
     * @return Request Экземпляр запроса HTTP Request.
     */
    private function getRequest(): Request
    {
        // Возвращаем экземпляр запроса HTTP Request из WeakMap.
        return self::$requestMap[$this];
    }

    /**
     * Настройка объекта с помощью запросов Builder и HTTP Request.
     *
     * Сохраняет переданные экземпляры запроса `Builder` и HTTP Request в `WeakMap`.
     * Затем вызывает метод `count()` для вычисления количества результатов.
     *
     * @param Builder $query Экземпляр запроса Builder.
     * @param Request $request Экземпляр запроса HTTP Request.
     *
     * @return ResourceShowService Возвращает текущий экземпляр класса для цепочки вызовов.
     */
    public function queryBuilder(Builder $query, Request $request): self
    {
        // Сохраняем экземпляр запроса Builder в WeakMap.
        self::$queryMap[$this] = $query;

        // Сохраняем экземпляр HTTP Request в WeakMap.
        self::$requestMap[$this] = $request;

        // Вычисляем количество результатов.
        $this->count();

        // Возвращаем текущий экземпляр класса для возможности цепочки вызовов.
        return $this;
    }

    /**
     * Вычисление количества результатов.
     *
     * Определяет начальную и конечную позиции для пагинации из параметров запроса `_start` и `_end`,
     * и вычисляет общее количество результатов на основе этих позиций.
     *
     * @return ResourceShowService Возвращает текущий экземпляр класса для возможности цепочки вызовов.
     */
    public function count(): self
    {
        // Получаем начальную позицию для пагинации из параметра `_start`.
        $this->start = (int) $this->getRequest()->input('_start', 0);

        // Получаем конечную позицию для пагинации из параметра `_end`.
        $this->end = (int) $this->getRequest()->input('_end', 0);

        // Вычисляем количество результатов на основе начальной и конечной позиции.
        if ($this->end > 0) {
            $this->count = min($this->getQuery()->count(), $this->end - $this->start + 1);
        } else {
            $this->count = max($this->getQuery()->count() - $this->start, 0);
        }

        // Возвращаем текущий экземпляр класса для возможности цепочки вызовов.
        return $this;
    }

    /**
     * Применение сортировки к запросу.
     *
     * Получает параметры сортировки из запроса и применяет их к запросу `Builder`.
     * Параметры сортировки могут быть в JSON формате в параметре `sort`.
     *
     * @return ResourceShowService Возвращает текущий экземпляр класса для возможности цепочки вызовов.
     */
    public function sort(): self
    {
        // Получаем массив параметров сортировки из запроса.
        $this->sort = $this->getRequest()->only('_order', '_sort') ?? [];

        if (isset($this->sort['_order'], $this->sort['_sort'])) {
            // Если параметры сортировки указаны, применяем их к запросу.
            $this->getQuery()->orderBy($this->sort['_sort'], $this->sort['_order']);
        }

        // Получаем параметр сортировки в формате JSON и декодируем его.
        $this->sort = json_decode($this->getRequest()->input('sort', ''), true);

        // Если параметр сортировки задан, применяем его.
        if (isset($this->sort['field'], $this->sort['order'])) {
            $field = $this->sort['field'];
            $order = strtoupper($this->sort['order']);
            // Применяем сортировку к запросу.
            $this->getQuery()->orderBy($field, $order);
        }

        // Возвращаем текущий экземпляр класса для возможности цепочки вызовов.
        return $this;
    }

    /**
     * Применяет фильтры к запросу.
     *
     * Получает параметры фильтрации из запроса, декодирует их из JSON и применяет фильтры к запросу `Builder`.
     * Обрабатывает фильтры по дате, текстовому содержимому и другим условиям.
     *
     * @return ResourceShowService Возвращает текущий экземпляр класса для возможности цепочки вызовов.
     * @throws InvalidArgumentException Если параметры фильтрации содержат некорректный JSON.
     */
    public function filter(): self
    {
        // Инициализируем переменную для хранения имени таблицы, которое будет извлечено из фильтров
        $table = '';

        // Инициализируем переменную для хранения полей содержимого, которые будут извлечены из фильтров
        $contentFields = [];

        // Получаем параметры фильтрации из запроса; по умолчанию используется пустой JSON
        $filterInput = $this->getRequest()->input('filter', '{}');

        // Декодируем параметры фильтрации из JSON в массив; если JSON пуст или некорректен, используем пустой массив
        $this->filter = json_decode($filterInput, true) ?? [];

        // Проверяем наличие ошибок при декодировании JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            // Если обнаружены ошибки, выбрасываем исключение с сообщением о некорректном JSON
            throw new \InvalidArgumentException('Invalid JSON in filter');
        }

        // Проверяем, есть ли в фильтре ключ 'contentFields', и если он присутствует, извлекаем его значения
        if (isset($this->filter['contentFields']) && is_array($this->filter['contentFields'])) {
            // Извлекаем поля для фильтрации содержимого из фильтра
            $contentFields = $this->filter['contentFields'];
            // Удаляем ключ 'contentFields' из массива фильтров
            unset($this->filter['contentFields']);
        }

        // Проверяем, есть ли в фильтре ключ 'table', и если он присутствует, извлекаем его значение
        if (isset($this->filter['table'])) {
            // Извлекаем имя таблицы из фильтра
            $table = $this->filter['table'];
            // Удаляем ключ 'table' из массива фильтров
            unset($this->filter['table']);
        }

        // Применяем фильтры к запросу
        foreach ($this->filter as $field => $value) {
            // Если значение фильтра является строкой, удаляем пробелы по краям
            if (is_string($value)) {
                $value = trim($value);
            }

            // Обрабатываем фильтры в зависимости от ключа
            switch ($field) {
                // Фильтрация по начальной дате
                case 'date_start':
                    // Применяем условие для фильтрации по дате начала
                    $this->getQuery()->where("{$table}.created_at", '>=', $value);
                    break;

                // Фильтрация по конечной дате
                case 'date_end':
                    // Преобразуем строку с датой в объект Carbon и устанавливаем конец дня
                    $date_end = \Carbon\Carbon::createFromFormat('Y-m-d', $value)->endOfDay();
                    // Применяем условие для фильтрации по дате окончания
                    $this->getQuery()->where("{$table}.created_at", '<=', $date_end);
                    break;

                // Фильтрация по содержимому в полях
                case 'content':
                    $this->getQuery()->where(function ($query) use ($contentFields, $value, $table) {
                        // Проходим по всем полям содержимого и применяем фильтрацию по каждому из них
                        foreach ($contentFields as $fieldToSearch) {
                            // Добавляем условие OR для поиска по каждому полю
                            $query->orWhere("{$table}.{$fieldToSearch}", 'like', "%{$value}%");
                        }
                    });
                    break;

                // Обработка других типов фильтров
                default:
                    // Если значение фильтра является массивом, используем whereIn для фильтрации по списку значений
                    if (is_array($value)) {
                        $this->getQuery()->whereIn($field, $value);
                    } else {
                        // В противном случае применяем фильтрацию по одному значению
                        $this->getQuery()->where($field, $value);
                    }
                    break;
            }
        }

        // Возвращаем текущий экземпляр класса для возможности цепочки вызовов
        return $this;
    }

    /**
     * Применяет параметры пагинации к запросу.
     *
     * Получает параметры пагинации из запроса, определяет начальную и конечную позиции элементов, и применяет их к запросу.
     *
     * @return ResourceShowService Возвращает текущий экземпляр класса для возможности цепочки вызовов.
     */
    public function pagination(): self
    {
        // Получаем массив параметров пагинации из параметров запроса; по умолчанию используется пустой массив
        $this->pagination = json_decode($this->getRequest()->input('pagination', ''), true) ?? [];

        // Получаем общее количество элементов в запросе
        $this->count = $this->getQuery()->count();

        // Проверяем наличие параметров 'page' и 'perPage' в массиве пагинации
        if (array_key_exists('page', $this->pagination) && array_key_exists('perPage', $this->pagination)) {
            // Определяем начальную позицию элементов для выборки на основе текущей страницы и количества элементов на странице
            $this->start = ($this->pagination['page'] - 1) * $this->pagination['perPage'];

            // Определяем конечную позицию элементов для выборки
            $this->end = $this->pagination['page'] * $this->pagination['perPage'];

            // Определяем количество элементов на текущей странице
            $countPage = $this->end - $this->start;

            // Применяем параметры пагинации к запросу: пропускаем начальное количество элементов и берем количество элементов на странице
            $this->getQuery()->skip($this->start)->take($countPage);
        }

        // Возвращаем текущий экземпляр класса для возможности цепочки вызовов
        return $this;
    }

    /**
     * Выполняет запрос с использованием текущей стратегии и возвращает результат.
     *
     * @param Builder $query Экземпляр запроса Builder, который будет использоваться для выполнения.
     *
     * @return mixed Результат выполнения запроса, который может быть любым типом в зависимости от стратегии.
     */
    public function execute(Builder $query): mixed
    {
        // Выполняем запрос с использованием текущей стратегии и возвращаем результат
        return $this->queryStrategy->execute($this->getQuery());
    }

    /**
     * Устанавливает стратегию запроса.
     *
     * @param QueryStrategyInterface $strategy Экземпляр стратегии запроса.
     *
     * @return ResourceShowService Возвращает текущий экземпляр класса для возможности цепочки вызовов.
     */
    public function setQueryStrategy(QueryStrategyInterface $strategy): self
    {
        // Устанавливаем стратегию запроса
        $this->queryStrategy = $strategy;

        // Возвращаем текущий экземпляр класса для возможности цепочки вызовов
        return $this;
    }

    /**
     * Устанавливает экземпляр запроса Builder.
     *
     * @param Builder $query Экземпляр запроса Builder.
     *
     * @return ResourceShowService Возвращает текущий экземпляр класса для возможности цепочки вызовов.
     */
    public function setQuery(Builder $query): self
    {
        // Сохраняем экземпляр запроса Builder в WeakMap
        self::$queryMap[$this] = $query;

        // Возвращаем текущий экземпляр класса для возможности цепочки вызовов
        return $this;
    }

    /**
     * Возвращает JSON-ответ с результатами запроса.
     *
     * Формирует и возвращает JSON-ответ, включая заголовки для указания типа содержимого, общего количества элементов и диапазона элементов.
     *
     * @return JsonResponse JSON-ответ с данными запроса и заголовками.
     */
    public function responseJson(): JsonResponse
    {
        // Формируем JSON-ответ с данными, общим количеством элементов и заголовками
        return response()
            // Возвращаем данные, полученные из запроса Builder
            ->json($this->execute($this->getQuery()))
            // Устанавливаем заголовок с типом содержимого ответа (JSON)
            ->header('Content-Type', 'application/json')
            // Устанавливаем заголовок с общим количеством элементов
            ->header('X-Total-Count', $this->count)
            // Устанавливаем заголовок с информацией о диапазоне элементов и общем количестве элементов
            ->header('Content-Range', "items {$this->start}-{$this->end}/" . $this->count)
            // Устанавливаем заголовок, разрешающий доступ к заголовкам X-Total-Count и Content-Range
            ->header('Access-Control-Expose-Headers', 'X-Total-Count, Content-Range');
    }

    /**
     * Применяет метаданные к объекту.
     *
     * Сохраняет метаданные в WeakMap, используя объект и ключ для идентификации.
     *
     * @param mixed $object Объект, к которому привязываются метаданные.
     * @param string $key Ключ для метаданных.
     * @param mixed $value Значение метаданных.
     */
    public function setMetadata(mixed $object, string $key, mixed $value): void
    {
        // Проверяем, есть ли уже метаданные для данного объекта, и если нет, инициализируем их как пустой массив
        if (!isset(self::$metadata[$object])) {
            self::$metadata[$object] = [];
        }

        // Устанавливаем метаданные для указанного ключа
        self::$metadata[$object][$key] = $value;
    }

    /**
     * Получает метаданные для объекта по указанному ключу.
     *
     * @param mixed $object Объект, для которого требуется получить метаданные.
     * @param string $key Ключ для метаданных.
     *
     * @return mixed Значение метаданных по указанному ключу или null, если метаданные не найдены.
     */
    public function getMetadata(mixed $object, string $key): mixed
    {
        // Возвращаем метаданные для объекта по ключу, или null, если метаданные не найдены
        return self::$metadata[$object][$key] ?? null;
    }

    /**
     * Выполняет запрос и возвращает результат.
     *
     * @return mixed Результат выполнения запроса, который может быть любым типом в зависимости от стратегии.
     */
    public function response(): mixed
    {
        // Выполняем запрос и возвращаем результат
        return $this->execute($this->getQuery());
    }
}
