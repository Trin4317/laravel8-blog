<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // using Eloquent mutator to ensure that passwords are always hashed before being persisted
    // must use convention: set[AttributeName]Attribute
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    // opposite of Eloquent mutator is accessor
    // public function getUsernameAttribute($username)
    // {
    //     return ucwords($username);
    // }

    public function getRouteKeyName()
    {
        return 'username';
    }

    // get all posts from a user
    public function posts()
    {
        // hasOne, hasMany, belongsTo, belongsToMany
        // does a user have many posts? true
        return $this->hasMany(Post::class);
    }
}
