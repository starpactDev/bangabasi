<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsnCode extends Model
{
    use HasFactory;

    protected $table = 'hsn_codes';

    protected $fillable = [
        'hsn_code',
        'description',
        'gst',
    ];
}
