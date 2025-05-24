<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $table = 'home';

    protected $fillable = [
        'banner_image',
        'upcoming_image_1',
        'upcoming_image_2',
        'upcoming_image_3',
        'upcoming_image_4',
        'what_image_1',
    ];
}
