<?php 
namespace App\Services\Threads;

use App\DataLayer\Models\User;
use App\DataLayer\Models\Thread;
use App\Services\Validation\NewThreadValidator;

class NewThread{
    
    public function __construct(){
        
    }
    
    public function create(User $author, $data, NewThreadValidator $validator){
        
        $validator->validate($data);
        
        $thread = new Thread();
        
        $thread->title = $data['title'];
        $thread->content = $data['content'];
        $thread->author = $author;
        $thread->created = time();
        
        $thread->save();
        
        return $thread;
    }
}