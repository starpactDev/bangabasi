<?php

namespace App\Models;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryHeaderImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'sub_category',
        'title'
    ];

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category', 'id'); // Adjust if 'sub_category' is an ID
    }
}
