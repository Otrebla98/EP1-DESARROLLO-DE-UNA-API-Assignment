<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    function index(){
        //return "hola world";
        $users=User::all();

        return response()->json([$users],200);
    }

    public function createUser(Request $request)
    {
        try{

            $data=$request->json()->all();

            $user=user::create([
                "name"=>$data["name"],
                "nickname"=>$data["nickname"],
                "email"=>$data["email"],
                "password"=>Hash::make($data["password"]),
                "token"=>str_random(60)
                ]);
                return response()->json($user,201);
            }
            catch(\illuminate\Database\QueryException $e){
                $respuesta=array ("error"=>$e -> errorInfo,"codgio"=>500);
                Return response()->json($respuesta,500);
            }
    }

    public function getUser($id)
    {
        $user=User::find($id);
        Return response()->json($user,200);
    }

    public function deleteUser($id)
    {
        $user=User::find($id);
        $user->delete();
        Return response()->json(["deleted"],204);
    }

    public function updateUser(Request $request,$id)
    {
        $data=$request->json()->all();
        $user=User::find($id);

        $user->name=$data["name"];
        $user->nickname=$data["nickname"];
        $user->email=$data["email"];

        $user->save();
        return response()->json($user,200);
    }

    public function login(Request $request)
    {
        $data=$request->json()->all();

        $user=User::where(["nickname" => $data["nickname"]])->first();

        if($user)
        {
            if(Hash::check($data["password"], $user->password))
            {
                return response() -> json ($user, 200);
            }
            else{
                $respuesta = array ('error'=>"El password es incorrecto",'codigo'=>404);
                return response() -> json ($respuesta, 404);
            }
        }
        else{
            $respuesta = array ('error'=>"El usuario es incorrecto",'codigo'=>404);
            return response() -> json ($respuesta, 404);
        }

        return response()->json($user,200);
    }


    public function database(Request $request)
    {
        $data=$request->json()->all();
        $results=DB::select('SELECT*FROM users where nickname=:nickname',["nickname"=>$data["nickname"]]);

        return response()->json($results,200);
    }
}
