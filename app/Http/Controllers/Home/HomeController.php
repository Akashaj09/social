<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;

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
		$peoplestofollow = DB::table("users")
								->select("users.*", "user_profile_picture.image")
								->join("user_profile_picture", "users.id", "=", "user_profile_picture.user_id")
								->where("users.id", "!=", Auth::id())
								->orderBy()
								->groupBy()
								->get();

							
		return view("home.index")->with(["profilepicture" => $profilepicture]);
	}
}
