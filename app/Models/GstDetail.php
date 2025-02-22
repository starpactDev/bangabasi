<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GstDetail extends Model
{
    use HasFactory;

    protected $table = 'gst_details';

    protected $fillable = [
        'user_id', 'gst_number', 'business_name', 'legal_name', 'business_type', 'address',
    ];

    /**
     * Relationship: GstDetails belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
