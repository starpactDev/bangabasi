<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAddress extends Model
{
    use HasFactory; 
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'country',
        'street_name',
        'apartment',
        'city',
        'state',
        'phone',
        'pin',
        'email',
    ];
}
