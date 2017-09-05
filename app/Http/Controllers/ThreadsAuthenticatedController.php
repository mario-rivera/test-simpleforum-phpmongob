<?php
namespace App\Http\Controllers;

use DI\Container;
use Twig_Environment;
use App\DataLayer\Models\Thread;
use App\Services\Auth\Auth;
use App\Services\Threads\NewThread;
use App\Services\Voting\Votes;
use App\Services\Validation\VotesValidator;

class ThreadsAuthenticatedController{

    public function __construct(Twig_Environment $twig, Auth $auth, Container $container){

        $auth->authenticatedAccess();

        $this->twig = $twig;
        $this->container = $container;
    }

    public function getNew(){

        return $this->twig->render('threads/new.html', ['data' => []]);
    }

    public function postNew(NewThread $newThreadService){

        $user = $this->container->get('AuthenticatedUser');

        try{

            $thread = $newThreadService->create( $user, $_POST, $this->container->get('App\Services\Validation\NewThreadValidator') );
        } catch( \Respect\Validation\Exceptions\ExceptionInterface $e ){

            return $this->twig->render('threads/new.html', [
                'error_message' => $e->getFullMessage(),
                'validation_messages' => $e->getMessages(),
                'data' => $_POST
            ]);
        } catch(\App\Exceptions\RegistrationException $e){

            return $this->twig->render('threads/new.html', ['error_message' => $e->getMessage(), 'data' => $_POST]);
        }

        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/threads/" . $thread->id);
        exit;
    }

    public function getVote( $id, Votes $votingService, VotesValidator $validator ){

        $user = $this->container->get('AuthenticatedUser');

        $thread = Thread::id( $id );
        if( !$thread ){
            http_response_code(404);
            return $this->twig->render('errors/404.html', []);
        }

        try{

            $votingService->vote( $user, $thread, $validator, $_GET );
        } catch( \Respect\Validation\Exceptions\ExceptionInterface $e ){
            
            return $this->twig->render('threads/thread.html', [
                'error_message' => $e->getFullMessage(),
                'validation_messages' => $e->getMessages(),
                'thread' => $thread
            ]);
        } catch( \Exception $e ){
            
            return $this->twig->render('threads/thread.html', [
                'error_message' => $e->getMessage(),
                'thread' => $thread
            ]);
        }
        
        return $this->twig->render('threads/thread.html', [
            'thread' => $thread,
            'vote_registered' => true
        ]);
    }
}
