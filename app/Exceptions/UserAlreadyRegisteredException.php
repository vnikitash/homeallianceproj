<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserAlreadyRegisteredException extends HttpException
{
    public function __construct(string $message = "", int $code = Response::HTTP_BAD_REQUEST, \Throwable $previous = null)
    {
        parent::__construct($code, __('exception.userAlreadyRegistered'), $previous);
    }
}