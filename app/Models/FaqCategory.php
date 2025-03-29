<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $table =  'faq_category';


    public function faq()
    {
        return $this->hasMany('App\Models\Faq', 'faq_category_id', 'id');
    }
}
