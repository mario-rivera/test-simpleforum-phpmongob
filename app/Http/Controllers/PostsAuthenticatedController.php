<?php
namespace App\Http\Controllers;

use DI\Container;
use Twig_Environment;
use App\DataLayer\Models\Post;
use App\Services\Auth\Auth;
use App\Services\Posts\NewPost;
use App\Services\Voting\Votes;
use App\Services\Validation\VotesValidator;

class PostsAuthenticatedController{

    public function __construct(Twig_Environment $twig, Auth $auth, Container $container){

        $auth->authenticatedAccess();
        
        $this->twig = $twig;
        $this->container = $container;
    }

    public function getNew(){
        
        return $this->twig->render('posts/new.html',[ 
            'thread_id' => ( isset($_GET['thread']) ) ? $_GET['thread'] : null,
            'data'  => null
        ]);
    }

    public function postNew(NewPost $newPostService){
        
        $user = $this->container->get('AuthenticatedUser');
        
        try{
            
            $post = $newPostService->create( $user, $_POST, $this->container->get('App\Services\Validation\NewPostValidator') );
        } catch( \Respect\Validation\Exceptions\ExceptionInterface $e ){
            
            return $this->twig->render('posts/new.html', [
                'error_message' => $e->getFullMessage(),
                'validation_messages' => $e->getMessages(),
                'data' => $_POST,
                'thread_id' => ( isset($_GET['thread']) ) ? $_GET['thread'] : null
            ]);
        } catch(\App\Exceptions\RegistrationException $e){
            
            return $this->twig->render('posts/new.html', [
                'error_message' => $e->getMessage(), 
                'data' => $_POST,
                'thread_id' => ( isset($_GET['thread']) ) ? $_GET['thread'] : null
            ]);
        }
        
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/threads/" . $_POST['thread_id']);
        exit;
    }
    
    public function getVote( $id, Votes $votingService, VotesValidator $validator ){

        $user = $this->container->get('AuthenticatedUser');

        $post = Post::id( $id );
        if( !$post ){
            http_response_code(404);
            return $this->twig->render('errors/404.html', []);
        }
        
        $thread = $post->thread;

        try{

            $votingService->vote( $user, $post, $validator, $_GET );
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
