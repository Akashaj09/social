<?php

namespace App\Http\Controllers\Home;

use App\User\Likes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class LiksController extends Controller
{
    public function likepost(Request $request) {
        $liks = new Likes;
        $exist = Likes::where("post_id", "=", $request->postid)
                        ->where("liker_id", "=", Auth::id())
                        ->first();

        if($exist){
            if($exist->flag == 1){
                $flag = 0;
                $liks = Likes::where("post_id", "=", $request->postid)
                        ->where("liker_id", "=", Auth::id())
                        ->update([
                            'flag' => $flag
                        ]);
            }else{
                $flag = 1;
                $liks = Likes::where("post_id", "=", $request->postid)
                        ->where("liker_id", "=", Auth::id())
                        ->update([
                            'flag' => $flag
                        ]);
            }
        }else{
            $flag = 1;
            $liks->post_id = $request->postid;
            $liks->liker_id = Auth::id();
            $liks->flag = $flag;
            $liks->save();
        }

        $likscounter = Likes::where("post_id", "=", $request->postid)
                                ->where("flag", "=", "1")
                                ->count();

        if($liks){
            return response()->json(["status" => true, "flag" => $flag, "likscounter" => $likscounter]);
        }else{
            return response()->json(["status" => false, "likscounter" => $likscounter]);
        }

    }


    public function likscounter($id)
    {
        $likscounter = Likes::where("post_id", "=", $id)
                            ->where("flag", "=", "1")
                            ->count();

        $liked = Likes::where("liker_id", "=", Auth::id())
                        ->where("post_id", "=", $id)
                        ->where("flag", "=", "1")
                        ->count();


        return response()->json([ "likscounter" => $likscounter, 'liked' => $liked ]);
    }
}
