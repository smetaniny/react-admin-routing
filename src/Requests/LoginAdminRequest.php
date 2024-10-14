<?php
declare(strict_types=1);

namespace Smetaniny\ReactAdminRouting\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Класс, представляющий запрос на аутентификацию администратора.
 */
class LoginAdminRequest extends FormRequest
{
    use TraitFormValidationResponse;
    /**
     * Правила валидации для запроса.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Переопределить сообщения об ошибках для определенных правил валидации.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Поле :attribute обязательно для заполнения.',
            'email.string' => 'Поле :attribute должно быть строкой.',
            'email.email' => 'Поле :attribute должно быть действительным адресом электронной почты.',
            'password.required' => 'Поле :attribute обязательно для заполнения.',
            'password.string' => 'Поле :attribute должно быть строкой.',
        ];
    }
}



