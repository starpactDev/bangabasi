<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'blog_head',
        'blog_description',
        'image',
        'slug',
        'author_name',
        'tags',
        'status',
        'view_count',
        'published_at',
    ];

    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }
}
