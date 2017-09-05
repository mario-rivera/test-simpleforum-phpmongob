<?php
namespace App\Http\Controllers;

use Twig_Environment;
use App\Services\Auth\Auth;
use DI\Container;
use App\DataLayer\Models\Thread;

class HomeController
{

    /**
     * @var Twig_Environment
     */
    private $twig;

    public function __construct(Twig_Environment $twig, Auth $auth, Container $container){
                
        $this->twig = $twig;
        $this->container = $container;
    }

    /**
     * Example of an invokable class, i.e. a class that has an __invoke() method.
     *
     * @see http://php.net/manual/en/language.oop5.magic.php#object.invoke
     */
    public function getHome(){
        
        // $user = $this->container->get('AuthenticatedUser');
        $threads = Thread::all();
        
        return $this->twig->render('home/home.html', [
            'threads' => $threads
        ]);
    }
}
