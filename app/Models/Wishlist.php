<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $guarded = ["id"];
    protected $fillable = ['product_id', 'user_id'];
    public function userDetails()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function productDetails()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
