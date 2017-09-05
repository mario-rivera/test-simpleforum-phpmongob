<?php
namespace App\DataLayer\Models;

use Purekid\Mongodm\Model;
use App\DataLayer\Models\Vote;
use MongoDBRef;

class Thread extends Model{

    static $collection = "threads";

    protected static $attrs = array(

         // 1 to 1 reference
        'author' => array('model'=>'App\DataLayer\Models\User','type'=> Model::DATA_TYPE_REFERENCE),
         // 1 to many references
        'posts' => array('model'=>'App\DataLayer\Models\Post','type'=> Model::DATA_TYPE_REFERENCES),
        'votes' => array('model'=>'App\DataLayer\Models\Vote','type'=> Model::DATA_TYPE_REFERENCES),
        // 'views' => array('default'=>0,'type'=> Model::DATA_TYPE_INTEGER),
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
