<?php

namespace App\Request\Lesson;

use App\Request\Validation;

/**
 * Class ActionRequest
 * @package App\Request\Lesson
 */
class ActionRequest extends Validation
{
    /**
     * Список правил валидации.
     *
     * @return array|string[]
     */
    public function rules(): array
    {
        return [
            'category' => 'required|integer|max:5',
            'returnType' => 'in_array:json,xml',
        ];
    }

    /**
     * Возврат списка сообщений при валидации.
     *
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'category.required' => __('validation.category_required'),
            'category.integer' => __('validation.category_integer'),
            'category.max' => __('validation.category_max'),
        ];
    }

    /**
     * Обработка условия отсутствия указанного формата возврата.
     */
    public function afterValidation(): void
    {
        if (!isset($this->params['returnType'])) {
            $this->params['returnType'] = 'json';
        }
    }
}