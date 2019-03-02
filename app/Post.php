<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model 
//implements AuthenticatableContract, AuthorizableContract
{
    //use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'body','imagen_url','user_id'
    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ ];
}