<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory; 
    
    protected $table = 'messages'; // Optional, since Laravel assumes 'messages' by default

    protected $fillable = [
        'name',
        'email',
        'message',
        'responsed',
    ];

    protected $casts = [
        'responsed' => 'boolean', // Cast 'responsed' to boolean
    ];
}
