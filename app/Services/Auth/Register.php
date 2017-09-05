<?php 
namespace App\Services\Auth;

use App\DataLayer\Models\User;
use App\Exceptions\RegistrationException;
use App\Services\Validation\RegisterValidator;

class Register{
    
    public function __construct(){
        
    }
    
    public function newUser( $data, RegisterValidator $validator ){
        
        $validator->validate( $data );
        $user = User::one( array('email' => $data['email'] ) );
        if( $user ){
            
            $e = new RegistrationException('User already exists');
            throw $e;
        }
        
        $user = new User();
        
    	$user->name = $data['name'];
    	$user->email = $data['email'];
        $user->password = md5($data['password']);
        
    	$user->save();
        
        return $user;
    }
}