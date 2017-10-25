<?php namespace Empari\Laravel\Support\Exceptions\Localization;

use League\Flysystem\Exception;

class LanguageNotSupportedException extends Exception
{
    public function __construct($message = "Language not supported.", $code = 422, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}