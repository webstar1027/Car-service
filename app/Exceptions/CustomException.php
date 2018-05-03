<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class CustomException extends Exception
{

   public function __construct($message) {
      
      parent::__construct($message);    

   }


}