<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function image()
    {
        return $this->belongsTo('App\Image');
    }

    protected $fillable = [
        'title', 'content', 'category_id', 'image_id', 'slug', 'users_id'
    ];
}
