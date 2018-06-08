<?php

namespace App\Http\Controllers\Home;

use App\User\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class CommentsController extends Controller
{
    public function getComments($id)
    {
        $comments = DB::table("comments")
                        ->select("comments.*", "users.firstname", "user_profile_picture.image")
                        ->join("post", "post.id", "=", "comments.post_id")
                        ->join("users", "users.id", "=", "comments.user_id")
                        ->join("user_profile_picture", "comments.user_id", "user_profile_picture.user_id")
                        ->where("post.id", "=", $id)
                        ->orderBy('comments.id', "DESC")
                        ->limit(2)
                        ->get();   

        if($comments){
            return response()->json(["status" => true, "comments" => $comments]);
        }else{
            return response()->json([ "status" => false ]);
        } 


    }

    public function postcomments(Request $request){
        $data = ["post_id" => $request->post_id, "user_id" => Auth::id(), "comments" => $request->comments, "status" => 1];
        $obj = Comment::create($data);

        $userimage = DB::table("user_profile_picture")
                        ->where("user_id", "=", Auth::id())
                        ->first();
        if(!$userimage){
            $userimage = ["image" => "No image"];
        }

        if($obj){
            return response()->json(["status" => true, "userimage" => $userimage]);
        }else{
            return response()->json(["status" => false]);
        }
    }
}
