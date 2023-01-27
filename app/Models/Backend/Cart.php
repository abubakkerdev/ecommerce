<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['product_quantity'];

    public function product_info()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
