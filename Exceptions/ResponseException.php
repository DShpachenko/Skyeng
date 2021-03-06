<?php

namespace App\Exceptions;

use Exception;

/**
 * Class ValidationException
 */
class ResponseException extends Exception
{
    public const SERVER_ERROR = 0;

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