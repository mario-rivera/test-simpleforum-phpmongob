<?php
namespace App\Http\Controllers;

use Twig_Environment;
use App\Services\Auth\Register;
use App\Services\Auth\Auth;
use DI\Container;

class RegisterController
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


    public function getRegister(){
        
        return $this->twig->render('auth/register.html', []);
    }
    
    public function postRegister( Register $registerService ){
        
        try{
            
            $user = $registerService->newUser( $_POST, $this->container->get('App\Services\Validation\RegisterValidator') );
        } catch( \Respect\Validation\Exceptions\ExceptionInterface $e ){
            
            return $this->twig->render('auth/register.html', [
                'error_message' => $e->getFullMessage(),
                'validation_messages' => $e->getMessages()
            ]);
        } catch(\App\Exceptions\RegistrationException $e){
            
            return $this->twig->render('auth/register.html', ['error_message' => $e->getMessage()]);
        }
        
        $this->auth->setAuthUserSession( $user );
        
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/");
        exit;
    }
}
