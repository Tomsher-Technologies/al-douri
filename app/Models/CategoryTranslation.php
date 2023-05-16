<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    protected $fillable = [
        'name',
        'lang',
        'category_id',
        'order_level',
        'meta_description',
        'meta_keyword',
        'og_title',
        'og_description',
        'twitter_title',
        'twitter_description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
