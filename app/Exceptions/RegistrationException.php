<?php 
namespace App\Exceptions;

use Exception;

class RegistrationException extends Exception{
    
    private $validation_errors;
    
    public function setValidationErrors(){
        
    }
}