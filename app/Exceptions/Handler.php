<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register()
    {
        $this->renderable(function (Request $request, Exception $exception) {
            if ($exception instanceof CustomException) {
                $exception->logError();
                return $exception->render($request);
            }

            return response()->json([
                'message' => $exception->getMessage(),
                'error' => $exception->getTraceAsString(),
            ], 500);
        });
    }
}
