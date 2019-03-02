<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CommentController extends Controller
{

    public function index(){
        $comment=new Comment();
        $comment->body="Cuerpo del nuevo Comentario";
        $comment->imagen_url="http://comentario.com";
        $comment->user_id=5;
        $comment->post_id=1;
        return response()->json([$comment],200);
    }
    public function createComment(Request $request)
    {
        $data=$request->json()->all();
        try
        {

        if($request->hasFile('imagen'))
        {

            if($request->file('imagen')->isValid())
            {
                $destinationPath="C:/Users/nivec/Documents/ESCUELA/Cuatri___#5/Cliente-Servidor/api/proyecto/storage/images";
                $fileName=str_random(10);
                $extension=$request->file('imagen')->getClientOriginalExtension();
                $fileComplete=$fileName.".".$extension;
                $comment=Comment::create([
                "body"=>$request->input('body'),
                "imagen_url"=>$fileComplete,
                "user_id"=>$request->input('user_id'),
                "post_id"=>$request->input('post_id')
                ]);
                $request->file('imagen')->move($destinationPath,$fileComplete);
            return response()->json([$comment],201);
            }
            else{
            return response()->json(['algo mal en HasFile'],404);
            }
        }
        else{
            $comment=Comment::create([
                "body"=>$data["body"],
                "user_id"=>$data["user_id"],
                "post_id"=>$data["post_id"]
                ]);
            return response()->json([$comment],201);

        }
        }
        catch(\illuminate\Database\QueryException $e)
        {
            $respuesta=array ("error"=>$e -> errorInfo,"codigo"=>500);
            Return response()->json($respuesta,500);
        }
    }

    public function getComments(){
        $comments=Comment::all();
        $like=Like::all();
        $numeroLikes=sizeof($like);
        $likes=Like::where(["comment_id"=>null])->get();
        $camposNulos=sizeof($likes);
        $numeroLikes=$numeroLikes-$camposNulos;
        $cuentaR=0;
        $busqueda=0;
        $array = array();
        while($cuentaR<$numeroLikes)
        {
            $comment=Comment::find($busqueda);
            if($comment!=null){
                $comment->num_likes = Like::where(["comment_id" => $busqueda])->get()->count();
                $num_likes = Like::where(["comment_id" => $busqueda])->get()->count();
                array_push($array, $comment);
                $cuentaR=$cuentaR+$num_likes;
                }
            $busqueda++;
        }
        return response()->json($array,200);
    }

    public function getCommentsbyID($id)
    {
        $comment=Comment::find($id);

        Return response()->json($comment,200);
    }
    public function getCommentbyUserID($id)
    {
    $comments=Comment::where(["user_id"=>$id])->get();
    return response()->json($comments,200);
    }

    public function updateComment(Request $request, $id)
    {
    $comment=Comment::find($id);
    $data=$request->json()->all();
    $comment->body=$data['body'];
    $comment->save();

    return response()->json($comment,200);
    }

    public function deleteComment( $id)
    {
    $comment=Comment::find($id);
    $comment->delete();

    return response()->json(["deleted"],200);
    }

}
