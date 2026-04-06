<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttachments extends Model
{
    protected $table = 'product_attachments';
    protected $fillable = ['product_id', 'path', 'is_main', 'file_type'];
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
