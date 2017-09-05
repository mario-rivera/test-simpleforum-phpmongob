<?php
namespace App\Services\Auth;

use DI\Container;
use App\DataLayer\Models\User;
use App\Services\Validation\LoginValidator;

class Auth {

    public function __construct( Container $container ){

        $this->container = $container;
    }

    public function isUserloggedIn(){

        return ( !empty($_SESSION['loggedIn']) );
    }

    public function guestAccess(){

        if( $this->isUserloggedIn() ){

            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/");
            exit;
        }
    }

    public function authenticatedAccess(){

        if( !$this->isUserloggedIn() ){

            header("Location: http://" . $_SERVER["HTTP_HOST"] . "/auth/login");
            exit;
        }

        return $this->getAuthenticatedUser();
    }
    
    public function getAuthenticatedUser(){
        
        try{

            $user = $this->container->get('AuthenticatedUser');
        }catch( \DI\NotFoundException $e ){

            $user = User::one( ['email' => $_SESSION['user_email']] );
            if( !$user ){

                throw new \Exception('Unable to retrieve authentication details, please login again.');
            }
            
            $this->injectUserToContainer( $user );
        }

        return $user;
    }

    public function dologin( $data, LoginValidator $validator ){

        $validator->validate( $data );
        $user = User::one( ['email' => $data['email'], 'password' => md5($data['password'])] );
        if(!$user){

            throw new \Exception('Username or password is incorrect');
        }

        $this->setAuthUserSession($user);
    }

    public function setAuthUserSession( User $user ){

        $_SESSION['loggedIn'] = true;
        $_SESSION['user_email'] = $user->email;

        return $this->injectUserToContainer( $user );
    }

    private function injectUserToContainer(User $user){

        return $this->container->set('AuthenticatedUser', $user);
    }
    
    public function doLogout(){

        $this->destroyAuthUserSession();
        return true;
    }

    private function destroyAuthUserSession(){

        unset($_SESSION["loggedIn"]);
        unset($_SESSION["user_email"]);

        session_destroy();

        return $this->container->set('AuthenticatedUser', null);
    }
}
