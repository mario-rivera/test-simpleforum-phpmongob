<?php
namespace App\Services\Voting;

use App\DataLayer\Models\User;
use Purekid\Mongodm\Model;
use App\Services\Validation\VotesValidator;
use App\DataLayer\Models\Vote;
use App\DataLayer\Models\Thread;
use MongoDBRef;
use MongoId;
use DateTime;

class Votes{

    public function __construct(){


    }

    public function vote( User $author, Model $model, VotesValidator $validator, $data ){

        $validator->validate( $data );
        $like = (bool) $data['like'];
        
        
        $vote_type_dbref = MongoDBRef::create( $model::$collection, $model->getId() );
        $vote = Vote::one([
             'author' => MongoDBRef::create( $author::$collection, $author->getId() ),
             'vote_type'    => $vote_type_dbref
        ]);
                
        if( $vote == null ){
            
            $vote = new Vote();
            
            $vote->author = $author;
            $vote->count = ($like) ? 1 : 0;
            $vote->last_voted = time();
            $vote->vote_type = $vote_type_dbref;
            
            $vote->save();
                        
            return $vote;
        } else {
            
            if( $this->authorCanVote( $author, $vote ) ){
                
                if( $like ){
                    
                    $vote->count += 1;
                } else {
                    
                    $vote->count = ( $vote->count > 0 ) ? $vote->count - 1 : 0;
                }
                
                $vote->last_voted = time();
                $vote->save();
                
                return $vote;
            } else {
                
                throw new \Exception( 'Please wait until tomorrow to vote again.' );
            }
        }
        
        // db.threads.find({'author': DBRef("users", ObjectId('59ad60b617af16001030dac2'))})
    }

    private function authorCanVote( User $author, Vote $vote ){
        
        $today = new DateTime();
        $today->setTime( 23, 59, 59 );
        
        $last_voted_timestamp = (int) $vote->last_voted->__toString();
        
        $last_voted = new DateTime();
        $last_voted->setTimestamp( $last_voted_timestamp );
        
        return ( $today <  $last_voted );
    }
}
