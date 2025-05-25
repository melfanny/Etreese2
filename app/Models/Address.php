<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recipient_name',
        'phone',
        'province_id',
        'province',
        'city_id',
        'city',
        'city_type',
        'postal_code',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
