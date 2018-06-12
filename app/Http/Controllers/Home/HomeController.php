<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\User;
use App\User\Post;


class HomeController extends Controller
{
	function __construct() {
		if(!Auth::check()){
			return redirect("/");
		}
	}


	public function index(){
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
		$posts = DB::table("post")
					->select("post.*", "users.firstname", "users.lastname")
					->join("following", "post.user_id", "=", "following.following_id")
					->join("users", "users.id", "=", "post.user_id")
					
					->where("following.user_id", "=", Auth::id())
					->orWhere("post.user_id", "=", Auth::id())
					->orderBy("post.id", "DESC")
					->groupBy("post.id")
					->paginate(40);
							
		return view("home.newsfeed")->with(["profilepicture" => $profilepicture, "peoplestofollow" => $peoplestofollow, "followercount" => $followercount, "followingcount" => $followingcount, "posts" => $posts]);
	}

	function images($id){
		$images = DB::table("user_profile_picture")
						->select("image")
						->where("user_id", "=", $id)
						->orderBy("id", "desc")
						->first();

		if(isset($images)){
			return response()->json(["image" => $images]);
		}else{
			return response()->json(["image" => ["image" => "people.png"]]);
		}
	}


	function people() {
		$profilepicture = DB::table("user_profile_picture")
							->where("user_id", "=", Auth::id())
							->orderBy("id", "DESC")
							->limit(15)
							->first();
		$peoplestofollow = DB::select("SELECT * FROM `users` WHERE `users`.`id` NOT IN (SELECT `following_id` FROM `following` WHERE `following`.`status`=1 AND `user_id`='".Auth::id()."') AND `users`.`id`!='".Auth::id()."' ORDER BY RAND() LIMIT 9");

		$pplstofollow = DB::select("SELECT * FROM `users` WHERE `users`.`id` NOT IN (SELECT `following_id` FROM `following` WHERE `following`.`status`=1 AND `user_id`='".Auth::id()."') AND `users`.`id`!='".Auth::id()."' ORDER BY RAND() LIMIT 40");


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
		return view("home.people")->with(["profilepicture" => $profilepicture, "peoplestofollow" => $peoplestofollow, "followercount" => $followercount, "followingcount" => $followingcount, "pplstofollow" => $pplstofollow]);
	}
}
