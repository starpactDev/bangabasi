<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marquee extends Model
{
    use HasFactory;
    protected $table = 'marquees';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'text',
    ];
}
