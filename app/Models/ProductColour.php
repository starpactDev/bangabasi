<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColour extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'colour_name'];
}
