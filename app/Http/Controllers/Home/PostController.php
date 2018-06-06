<?php

namespace App\Http\Controllers\Home;

use App\User\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use Auth;


class PostController extends Controller
{
    
    public function store(Request $request)
    {
        $files =  $request->postimage;
        $description = "";
        if(!$files){
            $request->validate([
                "description" => "required|min:10"
            ]);
            $description = $request->description;
        }

        if($files && $request->description){
            $description = $request->description;
        }
        if($files){
            $image = $files;
            $image->getRealPath();
            $name = uniqid("images_post_publish").".".$image->getClientOriginalExtension();
        }else{
            $name = "";
        }

        $data = ["description" => $description, "user_id" => Auth::id(), "images" => $name];
        Post::create($data);
        if($files){
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
        //
    }
}
