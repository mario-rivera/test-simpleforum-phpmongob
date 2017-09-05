<?php
namespace App\Services\Validation;

use Respect\Validation\Validator;

class VotesValidator{

    public function __construct(){

    }

    public function validate($data){

        Validator::key('like')->assert( $data );
        Validator::boolVal()->assert( $data['like'] );
    }
}
