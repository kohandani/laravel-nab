<?php

namespace App\Exceptions;

use Error;
use Exception;
use Throwable;
use ErrorException;
use ArgumentCountError;
use App\Traits\Responser;
use BadMethodCallException;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{

    use Responser;

    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }


    public function render($request,Throwable $e)
    {

        if($e instanceof MassAssignmentException){
            return $this->nresp($e->getmessage(),500);
        }

        if($e instanceof BadMethodCallException){
            return $this->nresp($e->getmessage(),500);
        }

        if($e instanceof Error){
            return $this->nresp($e->getmessage(),500);
        }

        if($e instanceof QueryException){
            return $this->nresp($e->getmessage(),500);
        }

        if($e instanceof ArgumentCountError){
            return $this->nresp($e->getmessage(),500);
        }

        if($e instanceof MethodNotAllowedHttpException){
            return $this->nresp($e->getmessage(),500);
        }

        if($e instanceof ErrorException){
            return $this->nresp($e->getmessage(),500);
        }

        if($e instanceof NotFoundHttpException){
            return $this->nresp("This route is not defind",404);
        }

        if($e instanceof Exception){
            return $this->nresp($e->getmessage(),500);
        }

        if($e instanceof ModelNotFoundException ){
            return $this->nresp($e->getmessage(),404);
        }

        if($e instanceof BindingResolutionException ){
            return $this->nresp($e->getmessage(),404);
        }

        if(config('app.debug')){
            return parent::render($request,$e);
        }

        return $this->nresp($e->getmessage(),500);
    }
}
