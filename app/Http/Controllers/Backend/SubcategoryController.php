<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Category;
use App\Models\Backend\subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $category = Category::all();
        $subcategory = subcategory::all();

        return view('backend.pages.subcategory.manage', [
            'category' => $category,
            'subcategory' => $subcategory,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'subcat_name' => ['required', 'unique:subcategories'],
            'category_id' => 'required',
        ], [
            'category_id.required' => 'Category name field is required'
        ]);

        subcategory::insert([
            'subcat_name' => $request->subcat_name,
            'category_id' => $request->category_id,
            'created_at' => Carbon::now()
        ]);

        return back()->with('store', 'Subcategory has now create.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcat_edit    = subcategory::find($id);
        $category       = Category::all();
        if (!is_null($subcat_edit))
        {
            return view('backend.pages.subcategory.edit', [
                'category'      => $category,
                'subcat_edit'   => $subcat_edit,
            ]);
        }
        else {
            return redirect()->route('subcategory.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'subcat_name' => ['required'],
            'category_id' => 'required',
        ], [
            'category_id.required' => 'Category name field is required'
        ]);

        $subcat_update    = subcategory::find($request->subcat_id);
        if (!is_null($subcat_update))
        {
            $subcat_update->update([
                'subcat_name'   => $request->subcat_name,
                'category_id'   => $request->category_id,
                'updated_at'    => Carbon::now(),
            ]);

            return redirect()->route('subcategory.index')->with('update', 'Subcategory has now updated.');
        }
        else {
            return back();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        subcategory::find($id)->delete();
        return redirect()->route('subcategory.index')->with('delete_subcat', 'default');
    }
}
