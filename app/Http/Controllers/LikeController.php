<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LikeController extends Controller
{

    public function index(){
        $Like=new Like();
        $Like->comment_id=2;
        $Like->post_id=1;
        $Like->user_id=5;
        return response()->json([$Like],200);

    }
    public function createLikeComment(Request $request)
    {
        $data=$request->json()->all();
        $like=Like::create([
        "comment_id"=>$data["comment_id"],
        "user_id"=>$data["user_id"]
        ]);
        return response()->json([$like],201);

    }
    public function createLikePost(Request $request)
    {

        $data=$request->json()->all();
        $like=Like::where(["post_id" => $data["post_id"]])->where(["user_id" => $data["user_id"]])->first();
        if($like == null)
        {
            $likes=Like::create([
            "post_id"=>$data["post_id"],
            "user_id"=>$data["user_id"]
            ]);
            return response()->json([$likes],201);
        }
        else
        {
            $like->delete();
            return response()->json(["deleted"],200);
        }

    }

    public function getLikesPostbyID($id)
    {
        $likes=Like::where(["post_id"=>$id])->get();
        return response()->json([$likes],200);
    }

    public function getLikesCommentbyID($id)
    {
    $likes=Like::where(["comment_id"=>$id])->get();
    return response()->json([$likes],200);
    }

    public function deleteLikeComment( $id)
    {
    $likes=Like::find($id);
    $likes->delete();

    return response()->json(["deleted"],200);
    }

    public function deleteLikePost( $id)
    {
    $likes=Like::find($id);
    $likes->delete();

    return response()->json(["deleted"],200);
    }


}
