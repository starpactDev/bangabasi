<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
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
