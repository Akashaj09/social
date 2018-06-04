<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;

class ProfilePicture extends Model
{
    protected $fillable = ["user_id", "image"];

    protected $table = "user_profile_picture";
}
