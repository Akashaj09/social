<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User\ProfilePicture;
use Auth;

class AdminController extends Controller
{
    public function logout(){
    	Auth::logout();
    	return redirect("/login");	
    }


    public function changeprofilepicture(Request $request) {
    	$file = $request->file;
    	if($file){
    		$ext = $file->getClientOriginalExtension();
    		$id = uniqid(Auth::user()->firstname);
    		$name = $id.".".$ext;
    		$allowed = array("jpg", "jpeg", "png");
    		if (in_array(strtolower($ext), $allowed)) {
    			$file->move(base_path()."/public/profile", $name);
    			$data = ["user_id" => Auth::id(), "image" => $name];
    			ProfilePicture::create($data);
    			return response()->json(["status" => true, "message" => "Profile picture updated"]);
    		}else{
    			return response()->json(["status" => false, "message" => "Image must be in jpg, jpeg or png format"]);
    		}
    	}else{
    		return response()->json(["status" => false, "message" => "An image is required"]);
    	}
    }
}
