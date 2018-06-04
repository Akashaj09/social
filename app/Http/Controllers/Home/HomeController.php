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
		return view("home.index")->with(["profilepicture" => $profilepicture]);
	}
}
