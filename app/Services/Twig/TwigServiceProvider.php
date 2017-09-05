<?php 
namespace App\Services\Twig;

use DI\Container;
use Twig_Loader_Filesystem;
use Twig_Environment;
use App\Services\Auth\Auth;

class TwigServiceProvider{
    
    public function register( Container $container, Auth $auth ){
        $loader = new Twig_Loader_Filesystem( rtrim($container->get('app.basedir'), '/') . '/app/Views' );
        $twig = new Twig_Environment( $loader, ['cache' => false] );
        
        $twig->addGlobal('app', $container);
        $twig->addGlobal('auth', $auth);
        
        return $twig;
    }
}