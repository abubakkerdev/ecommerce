<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_desc',
        'short_desc',
        'product_brand',
        'category_id',
        'subcategory_id',
        'product_price',
        'discount',
        'after_discount',
        'product_preview',
        'updated_at'
    ];

    public function category_info()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory_info()
    {
        return $this->belongsTo(subcategory::class, 'category_id');
    }

    public function product_thumbnail()
    {
        return $this->hasMany(ProductThumbnail::class, 'product_id', 'id');
    }
}
