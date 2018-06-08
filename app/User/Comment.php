<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;
use App\User\Post;

class Comment extends Model
{

    protected $fillable = ["post_id", "user_id", "comments", "status"];
    protected $primaryKey = "id";
    protected $table = "comments";

    public function post() {
    	return $this->belongsTo(Post::class);
    }
}
