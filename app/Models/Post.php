<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'title', 'slug', 'excerpt', 'body'];

    // another option to eager load relationship between models is defining $with property
    protected $with = ['category', 'author'];
    // however this would mean everytime we load a post Laravel would preload the relationships too when it doesnt need
    // to disable eager load in this case, use without(['category', 'author]) option
    // eg. Post::without('author')->first()

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeFilter($query) // allow you to call Post::newQuery()->filter()
    {
        if (request('search')) {
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('body', 'like', '%' . request('search') . '%');
        }
    }

    public function category()
    {
        // hasOne, hasMany, belongsTo, belongsToMany
        // does a post belong to a category? true
        return $this->belongsTo(Category::class);
    }

    // overwrite Model name to different name by explicit defining foreign key ('user_id')
    // without defining foreign key, Laravel will try to match the post with author_id key instead
    public function author()
    {
        // hasOne, hasMany, belongsTo, belongsToMany
        // does a post belong to a user? true
        return $this->belongsTo(User::class, 'user_id');
    }
}
