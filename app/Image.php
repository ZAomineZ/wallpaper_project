<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function category()
    {
        return $this->hasMany('App\Category');
    }

    protected $fillable = [
        'url', 'url_min', 'url_original', 'category_id', 'size',
    ];

}
