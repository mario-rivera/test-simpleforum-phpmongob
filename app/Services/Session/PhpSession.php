<?php
namespace App\Services\Session;

use App\Services\Auth\Auth;
use DI\Container;

class PhpSession{

    public function __construct( Auth $auth, Container $container ){

        $this->auth = $auth;
        $this->container = $container;
    }

    public function start(){

        if (session_status() == PHP_SESSION_NONE) {

            session_start();
        }
    }
    
    public function checkAuthenticationStatus(){
        
        if( $this->auth->isUserloggedIn() ){
            
            $user = $this->auth->getAuthenticatedUser();
        }
    }
}
