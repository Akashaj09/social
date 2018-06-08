<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    protected $fillable = ["post_id", "liker_id", "flag"];
    protected $primaryKey = "id";
    protected $table = "likes"; 
}
