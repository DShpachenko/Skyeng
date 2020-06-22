<?php

namespace App\Request;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidationException;
use Illuminate\Http\Request;

/**
 * Валидация входящего запроса.
 *
 * Class Validation
 */
class Validation
{
    /**
     * Параметры запроса.
     *
     * @var array
     */
    public $params;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Validation constructor.
     * @param Request $request
     * @throws ValidationException
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->prepareData();
        $this->make();
    }

    /**
     * Подготовка данных.
     */
    public function prepareData(): void
    {
        $this->params = $this->request->get('params');
    }

    /**
     * Запуск валидации.
     *
     * @throws ValidationException
     */
    public function make(): void
    {
        $this->beforeValidation();

        $rules = $this->rules();
        $messages = $this->messages();

        if (!$rules) {
            throw new ValidationException(__('errors.no_validation_rules'), ValidationException::EMPTY_VALIDATION_RULES);
        }

        if (!$messages) {
            throw new ValidationException(__('errors.no_validation_messages'), ValidationException::EMPTY_VALIDATION_MESSAGES);
        }

        $validator = Validator::make($this->params, $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors()->messages(), ValidationException::INVALID_PARAMS);
        }

        $this->afterValidation();
    }

    /**
     * Список правил валидации.
     *
     * @return array
     */
    protected function rules(): ? array
    {
        return null;
    }

    /**
     * Список сообщений для валидации запроса.
     *
     * @return array
     */
    protected function messages(): ? array
    {
        return null;
    }

    /**
     * Возможность расширить список выполняемых проверок до прохождения валидации.
     */
    public function beforeValidation(): void
    {
        // any
    }

    /**
     * Возможность расширить список выполняемых проверок после прохождения валидации.
     */
    public function afterValidation(): void
    {
        // any
    }
}