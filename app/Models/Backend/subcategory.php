<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'subcat_name',
        'category_id',
        'updated_at'
    ];
 
    public function category()
    {
    	return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }

}
