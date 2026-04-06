<?php

namespace App\Models;

use App\Traits\HasTranslatedAttributes;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Products extends Model
{

    use HasTranslations, HasTranslatedAttributes    ;

    public $translatable = ['name', 'description'];
    protected $fillable = [
        'name',
        'price',
        'discount_value',
        'discount_type',
        'description',
        'supcategories_id',
        'brands_id'
    ];


    public function subCategories()
    {
        return $this->belongsToMany(SubCategories::class, 'product_sub_categories', 'product_id', 'sub_category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'product_tags', 'product_id', 'tag_id');
    }

    public function images()
    {
        return $this->hasMany(ProductAttachments::class, 'product_id');
    }


    // داخل App\Models\Products.php

    protected $appends = ['final_price'];

    public function getFinalPriceAttribute()
    {
        $price = $this->price;
        $discount = $this->discount_value;
        $type = $this->discount_type;

        if ($discount <= 0) return $price;

        if ($type === 'percentage') {
            return $price - ($price * ($discount / 100));
        }

        return max(0, $price - $discount);
    }
}
