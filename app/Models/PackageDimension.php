<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageDimension extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'product_id',
        'length',
        'width',
        'height',
        'weight',
        'volumetric_weight',
    ];

    // Define the inverse relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Calculate volumetric weight on creation or update
    public static function boot()
    {
        parent::boot();

        static::saving(function ($dimension) {
            // Volumetric weight calculation (cm³ to kg)
            $dimension->volumetric_weight = ($dimension->length * $dimension->width * $dimension->height) / 5000;
        });
    }
}
