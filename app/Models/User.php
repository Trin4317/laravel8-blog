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

    // get all followers of a user
    public function followers()
    {
        // a single followee has many followship
        // a followship belongs to a specific follower
        // hence a single followee will belong to many followers
        // belongsToMany(class, relationship's intermediate table, foreign key name of the followee, foreign key name of the follower)
        // since we create a Followship indirectly, timestamp should be explicitly enabled
        return $this->belongsToMany(User::class, 'followships', 'followee_id', 'follower_id')->withTimestamps();
    }

    // get all users that one is following
    public function followings()
    {
        // a single follower has many followship
        // a followship belongs to a specific followee
        // hence a single follower will belong to many followees
        // belongsToMany(class, relationship's intermediate table, foreign key name of the follower, foreign key name of the followee)
        return $this->belongsToMany(User::class, 'followships', 'follower_id', 'followee_id')->withTimestamps();
    }
}
