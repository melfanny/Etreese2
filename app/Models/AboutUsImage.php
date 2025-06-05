<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUsImage extends Model
{
    protected $table = 'about_us_images';

    protected $fillable = [
        'header_image',
        'series_image_1',
        'series_image_2',
        'series_image_3',
        'series_image_4',
        'why_image_1',
        'why_image_2',
        'why_image_3',
    ];
}
