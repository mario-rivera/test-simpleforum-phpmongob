<?php
namespace App\Http\Controllers;

use App\Services\Auth\Auth;

class LogoutController
{

    public function __construct(Auth $auth){
        
        $this->auth = $auth;
    }
    
    public function getLogout(){
        
        $this->auth->doLogout();
        
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/");
        exit;
    }
}
