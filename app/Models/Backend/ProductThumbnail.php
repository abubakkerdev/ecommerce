<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductThumbnail extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_thumbnail',
        'updated_at',
    ];
}
