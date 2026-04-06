<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategories extends Model
{
    protected $fillable = ['name'];
    public function categories()
    {
        return $this->belongsToMany(
            Categories::class,
            'category_sub_categories',
            'sub_category_id',
            'category_id'
        );
    }


    public function products()
    {
        return $this->belongsToMany(Products::class, 'product_sub_categories', 'product_id', 'sub_category_id');
    }
}
