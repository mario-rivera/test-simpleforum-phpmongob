<?php 
namespace App\Services\Validation;

use Respect\Validation\Validator;

class RegisterValidator{
    
    public function __construct(){
        
    }
    
    public function validate($data){
        
        Validator::key('email')->key('password')->key('name')->assert($data);
        Validator::email()->setName("Email")->assert( $data['email'] );
        Validator::stringType()->notEmpty()->setName("Password")->assert( $data['password'] );
        Validator::stringType()->notEmpty()->setName("Name")->assert( $data['name'] );
    }
}