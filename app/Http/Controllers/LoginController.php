<?php
namespace App\Http\Controllers;

use Twig_Environment;
use App\Services\Auth\Auth;
use DI\Container;

class LoginController
{

    /**
     * @var Twig_Environment
     */
    private $twig;

    public function __construct(Twig_Environment $twig, Auth $auth, Container $container){
        
        $auth->guestAccess();
        
        $this->twig = $twig;
        $this->auth = $auth;
        $this->container = $container;
    }


    public function getLogin(){
        
        return $this->twig->render('auth/login.html', []);
    }
    
    public function postLogin(){
        
        try{
            
            $this->auth->doLogin( $_POST, $this->container->get('App\Services\Validation\LoginValidator') );
        } catch( \Respect\Validation\Exceptions\ExceptionInterface $e ){
            
            return $this->twig->render('auth/login.html', [
                'error_message' => $e->getFullMessage(),
                'validation_messages' => $e->getMessages()
            ]);
        } catch(\Exception $e){
            
            return $this->twig->render('auth/login.html', ['error_message' => $e->getMessage()]);
        }
        
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/");
        exit;
    }
}
