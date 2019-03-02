<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{

    public function index(){
        $post=new Post();
        $post->title="Hola mundo";
        $post->body="Cuerpo del post";
        $post->imagen_url="http://google.com";
        $post->user_id=5;
        return response()->json([$post],200);

    }

    public function createPost(Request $request)
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
                $post=Post::create([
                "title"=>$request->input("title"),
                "body"=>$request->input('body'),
                "imagen_url"=>$fileComplete,
                "user_id"=>$request->input('user_id')
                ]);
                $request->file('imagen')->move($destinationPath,$fileComplete);
            return response()->json([$post],201);
            }
            else{
            return response()->json(['algo mal'],404);
            }
        }
        else{
            $post=Post::create([
                "title"=>$data["title"],
                "body"=>$data["body"],
                "user_id"=>$data["user_id"]
                ]);
            return response()->json([$post],201);

        }
        }
        catch(\illuminate\Database\QueryException $e)
        {
            $respuesta=array ("error"=>$e -> errorInfo,"codigo"=>500);
            Return response()->json($respuesta,500);
        }
    }

    public function getPosts()
    {
    $posts=Post::all();
    return response()->json([$posts],200);
    }

    public function getPostsbyUserID($id)
    {
    $posts=Post::where(["user_id"=>$id])->get();
    return response()->json($posts,200);
    }

    public function getPostsbyID($id)
    {
    $posts=Post::find($id);
    return response()->json($posts,200);
    }

    public function updatePost(Request $request, $id)
    {
    $post=Post::find($id);
    $data=$request->json()->all();
    $post->title=$data['title'];
    $post->body=$data['body'];
    $post->save();

    return response()->json($post,200);
    }
    public function deletePost( $id)
    {
    $post=Post::find($id);
    $post->delete();

    return response()->json(["deleted"],200);
    }
}
