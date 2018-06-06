<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ["description", "user_id", "images"];
    protected $primaryKey = "id";
    protected $table = "post";
}
