<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\User\ProfilePicture;

class User extends Authenticatable
{
    use Notifiable;

 
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'flag',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profilepicture(){
    	return $this->hasMany(ProfilePicture::class);
    }
}
