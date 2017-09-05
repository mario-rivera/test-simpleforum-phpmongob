<?php 
namespace App\Services\Validation;

use Respect\Validation\Validator;

class LoginValidator{
    
    public function __construct(){
        
    }
    
    public function validate($data){
        
        Validator::key('email')->key('password')->assert($data);
        Validator::email()->setName("Email")->assert( $data['email'] );
        Validator::stringType()->notEmpty()->setName("Password")->assert( $data['password'] );
    }
}