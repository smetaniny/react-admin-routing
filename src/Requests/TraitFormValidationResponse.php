<?php
declare(strict_types=1);

namespace Smetaniny\ReactAdminRouting\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

/**
 * Трейт для ApplicationRequest
 */
trait TraitFormValidationResponse
{
    /**
     * Определение разрешения на выполнение запроса.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // В данном случае запрос всегда будет разрешен.
        return true;
    }

    /**
     * Обработка неудачной попытки валидации.
     *
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator): void
    {
        // Подготовка JSON-ответа с ошибками валидации.
        $response = $this->formResponse($validator);

        // Выброс исключения HTTP-ответа с JSON-ответом.
        throw new HttpResponseException($response);
    }

    /**
     * Генерация JSON-ответа для ошибок валидации.
     *
     * @param Validator $validator
     * @return JsonResponse
     */
    public function formResponse(Validator $validator): JsonResponse
    {
        // Создание JSON-ответа с ошибочным статусом и ошибками валидации.
        return response()->json([
            'status' => false,
            'data' => [],
            'errors' => $validator->errors(),
        ], 422);
    }
}
