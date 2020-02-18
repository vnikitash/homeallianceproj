<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }


    public function render($request, Exception $exception): JsonResponse
    {
        $message = $exception->getMessage();
        $code = $exception->getCode();

        if ($exception instanceof ValidationException) {
            $message = '';

            foreach ($exception->errors() as $field => $error) {
                $message .= implode(",", $error). " ";
            }

            $code = Response::HTTP_BAD_REQUEST;
        }

        $responseData = [
            'message' => $message
        ];

        //For production we are not showing users file and line
        if (env('APP_ENV') !== 'production') {
            $responseData['file'] = $exception->getFile();
            $responseData['line'] = $exception->getLine();
        }

        return response()->json($responseData, $code);
    }
}
