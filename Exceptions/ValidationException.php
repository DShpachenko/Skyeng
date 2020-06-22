<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception для валидации запросов.
 *
 * Class ValidationException
 */
class ValidationException extends Exception
{
    public const INVALID_PARAMS = 4;
    public const SERVER_ERROR = 5;
    public const EMPTY_VALIDATION_RULES = 6;
    public const EMPTY_VALIDATION_MESSAGES = 7;

    /**
     * ValidationException constructor.
     *
     * @param $message
     * @param $code
     */
    public function __construct($message, $code = self::SERVER_ERROR)
    {
        parent::__construct($message, $code);
    }
}