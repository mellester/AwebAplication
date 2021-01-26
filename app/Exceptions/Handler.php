<?php

namespace App\Exceptions;

use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * This custom method renders they $excetion to a html file and stores it      *
     * @param  \Throwable  $e
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {


        $filename = storage_path() . '/logs/' . Carbon::now()->toDateTimeLocalString() . '.html';
        $r = new Request();
        $data = $this->render($r, $exception);
        file_put_contents($filename, $data);
        copy($filename, storage_path() . '/logs/' . 'last-error.html');

        parent::report($exception);
    }
}
