<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'product_quality',
        'updated_at',
    ];


    public function product()
    {
    	return $this->belongsTo(Product::class, 'product_id');
    }

    public function color()
    {
    	return $this->belongsTo(Color::class, 'color_id');
    }

    public function rel_to_color()
    {
    	return $this->belongsTo(Color::class, 'color_id');
    }

    public function size()
    {
    	return $this->belongsTo(Size::class, 'size_id');
    }

    public function rel_to_size()
    {
    	return $this->belongsTo(Size::class, 'size_id');
    }
}
