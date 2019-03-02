<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model 
//implements AuthenticatableContract, AuthorizableContract
{
    //use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment_id','post_id','user_id'
    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ ];
}