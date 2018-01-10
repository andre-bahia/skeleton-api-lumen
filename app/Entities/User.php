<?php

namespace App\Entities;

use Illuminate\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements Transformable, AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use TransformableTrait, Authenticatable, Authorizable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'active', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'deleted_at', 'remember_token'
    ];

    // jwt need to implement the method
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // jwt need to implement the method
    public function getJWTCustomClaims()
    {
        return [];
    }
}
