<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;

use App\User\Comment;

class Post extends Model
{
    protected $fillable = ["description", "user_id", "images"];
    protected $primaryKey = "id";
    protected $table = "post";

     public function comments() {
    	return $this->hasMany(Comment::class);
    }
}
