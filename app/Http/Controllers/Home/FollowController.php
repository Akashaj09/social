<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class FollowController extends Controller
{
	public function follow(Request $request) {
	    $exist = DB::table("following")
	    			->where("user_id", "=", Auth::id())
	    			->where("following_id", $request->userid)
	    			->first();
	    if(isset($exist)){
	    	if($exist->status == 1){
	    		$status = 0;
	    	}else{
	    		$status = 1;
	    	}
	    	$obj = DB::table("following")
	    			->where("user_id", "=", Auth::id())
	    			->where("following_id", $request->userid)
	    			->update([
	    				'status' => $status
	    			]);
	    }else{
	    	$status = 1;
	    	$obj = DB::table("following")
	    				->insert([
	    					"user_id" => Auth::id(),
	    					"following_id" => $request->userid,
	    					'status' => $status
	    				]);
	    }

	    if($obj){
	    	return response()->json(["status" => true, "fl" => $status]);
	    }else{
	    	return response()->json(["status" => false, "fl" => $status]);
	    }
	}    
}
