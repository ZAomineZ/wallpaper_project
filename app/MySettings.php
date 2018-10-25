<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MySettings extends Model
{
    protected $fillable = [
        'about', 'favorite_music'
    ];
}
