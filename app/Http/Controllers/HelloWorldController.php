<?php
namespace App\Http\Controllers;

use Twig_Environment;
use App\Services\Auth\Auth;
use DI\Container;

class HelloWorldController
{

    /**
     * @var Twig_Environment
     */
    private $twig;

    public function __construct(Twig_Environment $twig, Auth $auth, Container $container){
        
        $auth->authenticatedAccess();
        
        $this->twig = $twig;
        $this->container = $container;
    }

    /**
     * Example of an invokable class, i.e. a class that has an __invoke() method.
     *
     * @see http://php.net/manual/en/language.oop5.magic.php#object.invoke
     */
    public function getHelloWorld(){
        
        return $this->twig->render('helloworld/helloworld.html', []);
    }
}
