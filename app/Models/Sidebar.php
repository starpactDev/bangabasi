<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sidebar extends Model
{
    use HasFactory;
    protected $fillable = [
        'main_image',
        'svg_1',
        'dialog_1',
        'svg_2',
        'dialog_2',
        'svg_3',
        'dialog_3',
    ];
}
