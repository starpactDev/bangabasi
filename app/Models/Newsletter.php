<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'newsletters';

    // The attributes that are mass assignable.
    protected $fillable = [
        'subject', 
        'content', 
        'status', 
        'sent_at', 
        'recipient_count', 
        'success_count', 
        'failure_count', 
        'from_email', 
        'from_name', 
        'type', 
        'unsubscribe_link', 
        'sent_email_ids',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'sent_at' => 'datetime',
        'attachment' => 'array', // Casting attachments to an array.
        'sent_email_ids' => 'array', // Casting the array of email IDs.
    ];


}
