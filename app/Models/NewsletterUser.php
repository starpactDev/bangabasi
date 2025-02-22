<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterUser extends Model
{
    use HasFactory;

    // Specify the fillable attributes
    protected $fillable = [
        'email',   // Add email to the fillable property
        'first_name',
        'last_name',
        'is_subscribed',
    ];
}
