<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    protected $fillable = ['name'];
    public function products()
    {
        return $this->belongsToMany(Products::class, 'product_tags', 'product_id', 'tag_id');
    }
}
