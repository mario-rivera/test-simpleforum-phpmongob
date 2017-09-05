<?php 
namespace App\Http\Controllers;

use DI\Container;
use Twig_Environment;
use App\DataLayer\Models\Thread;
use App\Services\Auth\Auth;

class ThreadsController{
    
    public function __construct(Twig_Environment $twig, Auth $auth, Container $container){
        
        $this->twig = $twig;
        $this->container = $container;
    }
    
    public function getThread( $id ){
        
        $thread = Thread::id( $id );
        if( !$thread ){
            http_response_code(404);
            return $this->twig->render('errors/404.html', []);
        }
        
        return $this->twig->render('threads/thread.html', [
            'thread' => $thread
        ]);
    }
}