<?php
namespace App\DataLayer\Models;

use Purekid\Mongodm\Model;
use App\DataLayer\Models\Vote;
use MongoDBRef;

class Post extends Model{

    static $collection = "posts";

    protected static $attrs = array(

         // 1 to 1 reference
        'author' => array('model'=>'App\DataLayer\Models\User','type'=> Model::DATA_TYPE_REFERENCE),
        'thread' => array('model'=>'App\DataLayer\Models\Thread','type'=> Model::DATA_TYPE_REFERENCE),
         // 1 to many references
        'votes' => array('model'=>'App\DataLayer\Models\Vote','type'=> Model::DATA_TYPE_REFERENCES),
        'created' => array('type' => Model::DATA_TYPE_TIMESTAMP),
    );
    
    public function getTotalVotes(){
        
        $count = 0;
        
        $vote_type_dbref = MongoDBRef::create( $this::$collection, $this->getId() );
        $votes = Vote::find([
             'vote_type'    => $vote_type_dbref
        ]);
        
        foreach( $votes as $vote ){
            
            $count += $vote->count;
        }
        
        return $count;
    }
}
