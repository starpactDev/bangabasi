<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSectionProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'product_section_id',
    ];

    public function section_product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
