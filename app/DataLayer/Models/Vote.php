<?php
namespace App\DataLayer\Models;

use Purekid\Mongodm\Model;

class Vote extends Model{

    static $collection = "votes";

    protected static $attrs = array(

         // 1 to 1 reference
        'author' => array('model'=>'App\DataLayer\Models\User','type'=> Model::DATA_TYPE_REFERENCE),
        'count' => array('default'=>0,'type'=> Model::DATA_TYPE_INTEGER),
        'last_voted' => array('type' => Model::DATA_TYPE_TIMESTAMP),
        // 'vote_type' => array('type' => Model::DATA_TYPE_REFERENCE)
    );
}
