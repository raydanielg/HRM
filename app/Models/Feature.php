<?php

namespace App\Models;


class Feature extends \Eloquent
{

    protected $fillable = ['title','description','image'];
    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return asset_url('features/' . $this->image);

    }
}
