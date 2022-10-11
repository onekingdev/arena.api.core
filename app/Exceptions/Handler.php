<?php

namespace App\Exceptions;

use Auth;
use Illuminate\Database\QueryException;
use Throwable;
use Exception;
use App\Traits\Response;
use App\Facades\Exceptions\Disaster;
use Illuminate\Validation\ValidationException;
use App\Contracts\Exceptions\Exception as ExceptionContract;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler {
    use Response;

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

    private string $disasterExceptions = ExceptionContract::class;

    /**
     * Report or log an exception.
     *
     * @param \Throwable $e
     * @return void
     * @throws Exception
     */
    public function report(Throwable $e) {
        if ($e instanceof $this->disasterExceptions) {
            /** @var Exception $e */
            Disaster::handleDisaster($e);
        }

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable $exception) {
        if ($exception instanceof ValidationException) {
            return $this->invalidJson($request, $exception);
        }

        $response = [
            "error" => "Sorry, we cannot execute your request",
        ];

        if (config("api.debug")) {
            $response["exception"] = get_class($exception);
            $response["trace"] = $exception->getTrace();
        }

        $message = $exception->getMessage();

        if (is_int($exception->getCode()) && $exception->getCode() >= 400 && $exception->getCode() <= 500) {
            $statusCode = $exception->getCode();
        } else {
            $statusCode = 400;
        }

        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $this->getStatusCode($exception);
        } else if ($exception instanceof ExceptionContract) {
            Disaster::handleDisaster($exception);
        }

        return ($this->failure($response, $message, $statusCode));
    }

    /**
     * Get the status code from the exception.
     *
     * @param \Exception $exception
     *
     * @return int
     */
    protected function getStatusCode(Exception $exception) {
        if ($exception instanceof \Illuminate\Validation\ValidationException) {
            return $exception->status;
        }

        if ($exception instanceof QueryException) {
            return 500;
        }

        return $exception instanceof HttpExceptionInterface ? $exception->getStatusCode() : 500;
    }

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            \Sentry\configureScope(function (\Sentry\State\Scope $scope): void {
                $objUser = Auth::user();

                if (is_null($objUser)) {
                    $arrUser = [
                        "ip_address" => request()->ip()
                    ];
                } else {
                    $arrUser = [
                        "id" => $objUser->user_uuid,
                        "username" => $objUser->name,
                        "email" => $objUser->primary_email->user_auth_email
                    ];
                }

                $scope->setUser($arrUser);
            });
            if ($this->shouldReport($e) && app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });
    }
}
