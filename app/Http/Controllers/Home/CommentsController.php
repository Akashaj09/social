<?php

namespace App\Http\Controllers\Home;

use App\User\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User\Post;
use DB;
use Auth;

class CommentsController extends Controller
{

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

    public function allcomments($id) {
        $profilepicture = DB::table("user_profile_picture")
                            ->where("user_id", "=", Auth::id())
                            ->orderBy("id", "DESC")
                            ->first();
        $peoplestofollow = DB::select("SELECT * FROM `users` WHERE `users`.`id` NOT IN (SELECT `following_id` FROM `following` WHERE `following`.`status`=1 AND `user_id`='".Auth::id()."') AND `users`.`id`!='".Auth::id()."' ORDER BY RAND() LIMIT 9");


        $followercount = DB::table("following")
                            ->select("following_id")
                            ->where("following_id", "=", Auth::id())
                            ->where("status", "!=", "0")
                            ->count();
        $followingcount = DB::table("following")
                            ->select("following_id")
                            ->where("user_id", "=", Auth::id())
                            ->where("status", "!=", "0")
                            ->count();
        $post = "no";
        $posts = DB::table("post")
                    ->select("post.*", "users.firstname", "users.lastname")
                    ->join("following", "post.user_id", "=", "following.following_id")
                    ->join("users", "users.id", "=", "post.user_id")
                    ->where("post.id", "=", $id)
                    ->groupBy("post.id")
                    ->first();

        $comments = DB::table("comments")
                        ->select("comments.*", "users.firstname", "users.lastname")
                        ->join("users", "comments.user_id", "=", "users.id")
                        ->where("comments.post_id", "=", $id)
                        ->get();
        
        return view("home.comments", compact("profilepicture", "peoplestofollow", "followercount", "followingcount", "post", "posts", "comments"));
    }
}
