<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'bank_name', 'branch_name', 'ifsc_code', 'account_number', 'account_holder_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
