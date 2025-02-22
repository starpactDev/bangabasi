<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topbar extends Model
{
    use HasFactory;

    protected $fillable = [
        'layout_type', 'banner_image', 'overlay_text_heading', 'overlay_text_body',
        'category_1_id', 'category_2_id', 'category_3_id', 'category_4_id',
        'section_1_image', 'section_2_image',
    ];

    public function category1()
    {
        return $this->belongsTo(Category::class, 'category_1_id');
    }
    public function category2()
    {
        return $this->belongsTo(Category::class, 'category_2_id');
    }

    public function category3()
    {
        return $this->belongsTo(Category::class, 'category_3_id');
    }

    public function category4()
    {
        return $this->belongsTo(Category::class, 'category_4_id');
    }
}
