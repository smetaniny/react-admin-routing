<?php

return [
    // Общин данные по умолчанию для RouteHandler
    'common' => [
        'status' => 200,   // Статус ответа по умолчанию
        'data' => [],     // Данные ответа по умолчанию (пустой массив или другие данные)
        'errors' => [],   // Ошибки ответа по умолчанию (пустой массив или другие данные)
    ],

    // Данные по умолчанию для AdminRouteHandlerServices
    'admin' => [
        'strategy' => 'get',  // Стратегия по умолчанию для ресурсов (например, first или get)
        'type' => '',           // Тип запроса по умолчанию (например, resource - для работы с ресурсами)
    ],
];
