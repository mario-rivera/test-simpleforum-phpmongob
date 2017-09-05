<?php 
namespace App\Services\Validation;

use Respect\Validation\Validator;

class NewPostValidator{
    
    public function __construct(){
        
    }
    
    public function validate($data){
        
        Validator::key('thread_id')->key('content')->assert($data);
        Validator::stringType()->notEmpty()->setName("Thread Id")->assert( $data['thread_id'] );
        
        Validator::stringType()->length(1, 100)->setName('Content')->assert( $data['content'] );
        try{
            
            $pattern = '(?xi)\b((?:https?://|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))';
            Validator::not( Validator::regex("#$pattern#i") )
            ->setName('Content')->assert( $data['content'] );
        }catch(\Respect\Validation\Exceptions\ExceptionInterface $e){
            
            $e->findMessages([
                'regex' => '{{name}} must not contain urls'
            ]);
            throw $e;
        }
    }
}