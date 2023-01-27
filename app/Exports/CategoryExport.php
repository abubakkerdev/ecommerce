<?php

namespace App\Exports;

use App\Models\Backend\subcategory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CategoryExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        return view('backend.pages.category.download', [
            'subcategory' => subcategory::all()
        ]);
    }
}
