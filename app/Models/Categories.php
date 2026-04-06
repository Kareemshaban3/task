<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['name'];

    public function subCategories()
    {
        return $this->belongsToMany(
            SubCategories::class,
            'category_sub_categories',
            'category_id',      
            'sub_category_id'   
        );
    }
}
