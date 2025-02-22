<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $fillable = ['name','key'];
    public function categoryDetails()
    {
        return $this->belongsTo(Category::class, 'key', 'id');
    }
}
