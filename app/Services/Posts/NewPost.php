<?php
namespace App\Services\Posts;

use App\DataLayer\Models\User;
use App\DataLayer\Models\Post;
use App\DataLayer\Models\Thread;
use App\Services\Validation\NewPostValidator;

class NewPost{

    public function __construct(){

    }

    public function create(User $author, $data, NewPostValidator $validator){

        $validator->validate($data);
        
        $thread = Thread::id( $data['thread_id'] );
        if( !$thread ){
            
            throw new \Exception('Unable to create comment, related thread not found.');
        }
        
        $post = new Post();
        $post->author = $author;
        $post->created = time();
        $post->content = $data['content'];
        $post->thread = $thread;
        $post->save();
        
        $thread->posts->add($post);
        $thread->save();
        
        return $post;
    }
}
