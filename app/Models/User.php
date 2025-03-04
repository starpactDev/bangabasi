<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\GstDetail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "firstname",
        "lastname",
        "email",
        "password",
        "contact_number",
        "phone_number",
        "image",
        "usertype",
        "email_verified_at"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function pickupAddress()
    {
        return $this->hasOne(PickupAddress::class);
    }

    public function gstDetails()
    {
        return $this->hasOne(GstDetail::class);
    }

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }
}
