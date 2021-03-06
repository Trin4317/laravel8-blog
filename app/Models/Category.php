<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function posts()
    {
        // hasOne, hasMany, belongsTo, belongsToMany
        // does a category has many posts? true
        return $this->hasMany(Post::class);
    }
}
