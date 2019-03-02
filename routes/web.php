<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/createUser', ["uses" => "UserController@createUser"]);
$router->get ('/key',function(){return str_random(60);});



$router->group(['middleware'=> ['auth']], function() use ($router)
{
$router->get('/users', ["uses" => "UserController@index"]);
$router->get('/user/{id}', ["uses" => "UserController@getUser"]);
$router->delete('/user/{id}', ["uses" => "UserController@deleteUser"]);
$router->put('/user/{id}',["uses" =>"UserController@updateUser"]);
});

$router->post('/login',["uses" =>"UserController@login"]);

$router->post('/post',["uses" =>"PostController@createPost"]);
$router->get('/posts/{id}',["uses" =>"PostController@getPostsbyUserID"]);
$router->get('/post/{id}',["uses" =>"PostController@getPostsbyID"]);
$router->get('/post',["uses" =>"PostController@getPosts"]);
$router->put('/post/{id}',["uses" =>"PostController@updatePost"]);
$router->delete('/post/{id}',["uses" =>"PostController@deletePost"]);

$router->post('/comments', ["uses" => "CommentController@index"]);
$router->post('/comment', ["uses" => "CommentController@createComment"]);
$router->get('/comments', ["uses" => "CommentController@getComments"]);
$router->get('/comment/{id}', ["uses" => "CommentController@getCommentsbyID"]);
$router->get('/comments/{id}', ["uses" => "CommentController@getCommentbyUserID"]);
$router->put('/comment/{id}',["uses" =>"CommentController@updateComment"]);
$router->delete('/comment/{id}',["uses" =>"CommentController@deleteComment"]);

$router->post('/like',["uses" =>"LikeController@index"]);
$router->post('/likesComment', ["uses" => "LikeController@createLikeComment"]);
$router->post('/likesPost', ["uses" => "LikeController@createLikePost"]);
$router->get('/likesComment/{id}', ["uses" => "LikeController@getLikesCommentbyID"]);
$router->get('/likesPost/{id}', ["uses" => "LikeController@getLikesPostbyID"]);
$router->delete('/likesComment/{id}', ["uses" => "LikeController@deleteLikeComment"]);
$router->delete('/likesPost/{id}', ["uses" => "LikeController@deleteLikePost"]);




