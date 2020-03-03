<?php


namespace MicroLink\Common\Exceptions;

use Exception as BaseException;
use Throwable;

/**
 * Class Exception.
 */
class Exception extends BaseException
{
    public function __construct(string $message = "", int $code = 1000, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
