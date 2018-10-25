<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function images()
    {
        return $this->belongsTo('App\Image');
    }

    protected $fillable = [
        'name', 'slug', 'images_id', 'users_id'
    ];
}
