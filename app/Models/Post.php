<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post extends Model
{
    use HasFactory;

    public $title;
    public $excerpt;
    public $date;
    public $body;
    public $slug;

    public function __construct($title, $excerpt, $date, $body, $slug) {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug = $slug;
    }

    public static function find($slug) {
        // of all the blog posts, find the one with a slug that matches the one that was requested

        return static::findAll()->firstWhere('slug', $slug);
    }
    public static function findAll() {
        // Find all files in "posts" directory and put them into Collection
        // then map over each item, parse them into document
        // then map again, make them into Post object

        return collect(File::files(resource_path("posts/")))
        ->map(function ($file) {
            return YamlFrontMatter::parseFile($file);
        })
        ->map(function ($document){
            return new Post(
                $document->title,
                $document->excerpt,
                $document->date,
                $document->body(),
                $document->slug
            );
        })
        ->sortByDesc('date');
    }
}
