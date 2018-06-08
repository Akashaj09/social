<?php

namespace App\Http\Controllers\Home;

use App\User\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use Auth;
use File;
use DB;


class PostController extends Controller
{
    
    public function store(Request $request)
    {
        $files =  $request->postimage;
        $description = "";
        if(!$request->hasFile("postimage")){
            $request->validate([
                "description" => "required|min:10"
            ]);
            $description = $request->description;
        }

        if($request->hasFile($request->postimage) && $request->description){
            $description = $request->description;
        }
        $description = nl2br($request->description);
        if($request->hasFile("postimage")){
            $image = $files;
            $image->getRealPath();
            $name = uniqid("images_post_publish").".".$image->getClientOriginalExtension();
        }else{
            $name = "no image";
        }

        $data = ["description" => $description, "user_id" => Auth::id(), "images" => $name];
        Post::create($data);
        if($request->hasFile("postimage")){
            $img = Image::make($image->getRealPath());
            $img->save(public_path()."/postimage/".$name, 50);
        }

        return response()->json(["status" => true, "message" => "Posted"]);
    }

    public function show(Post $post)
    {
        //
    }

   
    public function edit(Post $post)
    {
        //
    }


    public function update(Request $request, Post $post)
    {
        //
    }

  
    public function destroy(Post $post)
    {
        if($post->user_id == Auth::id()){
            if($post->images == "no image"){
                $post->delete();
                return response()->json(["status", true, "message" => "Post deleted"]);
            }else{
                if(strpos($post->images,  Auth::user()->firstname) !== false){
                    DB::table("user_profile_picture")
                        ->where("image", "=", $post->images)
                        ->delete();
                }
                File::delete("postimage/$post->images");
                $post->delete();
                return response()->json(["status", true, "message" => "Post deleted"]);
            }
        }else{
            return response()->json(["status", false, "message" => "You are not authorized to delete this post"]);
        }
    }
}
