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

    // instead of regenerate request('search') in Post model
    // we accept an array list of filters
    public function scopeFilter($query, array $filters) // allow you to call Post::newQuery()->filter()
    {
        // instead of using if(), use query builder's when()
        // $search = $filters['search']
        $query->when($filters['search'] ?? false, function($query, $search) {  // null coalescing operator (??)
                                                                                // equals to isset($filters['search']) ? $filters['search'] : false;
            $query->where(fn($query) =>
                // group up the OR condition
                // eg: WHERE ( `title` like '%doloribus%' or `body` like '%doloribus%' ) and EXISTS ( SELECT * FROM `categories` WHERE `posts`.`category_id` = `categories`.`id` and `slug` = 'work' )
                $query->where('title', 'like', '%' . $search . '%')
                        ->orWhere('body', 'like', '%' . $search . '%'));
        });

        $query->when($filters['category'] ?? false, function($query, $category) {
            $query->whereHas('category', function($query) use ($category) {
                $query->where('slug', $category);
            });
            // using arrow function would reduce the need of use ($category)
            // $query->whereHas('category', fn($query) => $query->where('slug', $category));
        });

        $query->when($filters['author'] ?? false, fn ($query, $author) =>
            $query->whereHas('author', fn($query) =>
                $query->where('username', $author)));
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
