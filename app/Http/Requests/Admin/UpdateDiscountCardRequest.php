<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|unique:discount_card',
            'percent' => 'required|integer|between:0,100'
        ];
    }

    /**
     * Получить сообщения об ошибках для определенных правил валидации.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'code.required' => 'Введите код карты',
            'code.unique' => 'Код уже существует у другой карты',
            'percent.required' => 'Введите процент скидки',
            'percent.integer' => 'Введите процент скидки от 0 до 100',
            'percent.between' => 'Процент скидки должен иметь значение от 0 до 100',
        ];
    }
}
