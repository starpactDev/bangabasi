<?php

namespace App\Models;

use App\Models\ProductSize;
use App\Models\BrandProduct;
use App\Models\ProductImage;
use App\Models\ProductColour;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'hsn_id',
        'name',
        'tags',
        'category',
        'sub_category',
        'collections',
        'item_code',
        'original_price',
        'offer_price',
        'discount_percentage',
        'short_description',
        'full_details',
        'is_active'
    ];


    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function productColours()
    {
        return $this->hasMany(ProductColour::class);
    }
    public function productBrand()
    {
        return $this->hasOne(BrandProduct::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->active();
    }

    public function categoryDetails()
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }

    public function subCategoryDetails()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category', 'id');
    }
    public function collection()
    {
        return $this->belongsTo(Collection::class, 'collections', 'id');
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'user_id', 'user_id'); // Match user_id from sellers table
    }
}
