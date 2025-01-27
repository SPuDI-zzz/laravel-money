<?php

namespace PostScripton\Money\Exceptions;

class CurrencyDoesNotExistException extends ValueErrorException
{
    public function __construct(
        string $method,
        int $arg_num,
        string $arg_name = null,
        string $message = null,
        $code = 0,
        BaseException $previous = null
    ) {
        parent::__construct(
            $method,
            $arg_num,
            $arg_name,
            'must have standard currency code: alphabetical or numeric',
            "The currency \"{$message}\" doesn't exist",
            $code,
            $previous
        );
    }
}