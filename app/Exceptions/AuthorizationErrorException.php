<?php

namespace App\Exceptions;

use Illuminate\Http\Response;

class AuthorizationErrorException extends \Exception
{
    public function __construct(string $message = "", int $code = Response::HTTP_BAD_REQUEST, \Throwable $previous = null)
    {
        parent::__construct(__('exception.authError'), $code, $previous);
    }
}