<?php

namespace App\Http\Requests\LaboratoryAssistant;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
            'surname' => 'required',
            'name' => 'required',
            'sex' => 'required',
            'partner_id' => 'required',
//            'doctor_id' => 'required',
            'pregnancy' => 'sometimes|nullable|integer|between:0,40',
            'kdl1' => 'required',
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
            'surname.required' => 'Введите фамилию',
            'name.required' => 'Введите имя',
            'sex.required' => 'Укажите пол',
            'partner_id.required' => 'Выберите отделение',
//            'doctor_id.required' => 'Выберите врача',
            'pregnancy.integer' => 'Введите количество недель от 0 до 40',
            'pregnancy.between' => 'Срок должен быть меньше или равен 40 неделям',
            'kdl1.required' => 'Укажите номер заявки (KDL)',
        ];
    }
}
