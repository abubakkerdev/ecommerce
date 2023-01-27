<?php

namespace App\Http\Controllers\Backend;

use App\Exports\CategoryExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Models\Backend\Category;
use App\Models\Backend\subcategory;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();
        $trash_cate = Category::onlyTrashed()->get();
        return view('backend.pages.category.manage', compact('category', 'trash_cate'));
    }

    // this need when you without login ,, view this page...
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category_id = Category::insertGetId([
            'cat_name'      => $request->cat_name,
            'auth_id'       => Auth::id(),
            'cat_desc'      => $request->cat_desc,
            'created_at'    => Carbon::now()
        ]);

        $image              = $request->category_image;
        $image_extention    = $image->getClientOriginalExtension();
        $image_name         = $category_id.'.'.$image_extention;
        $location           = public_path('backend/uploads/category/'. $image_name);

        Image::make($image)->resize(500, 333)->save($location);

        $category           = Category::find($category_id);

        if (!is_null($category))
        {
            $category->update([
                'category_image' => $image_name
            ]);
        }

        return back()->with('category_store', 'Category has now create.');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category_info = Category::find($id);
        return view('backend.pages.category.edit', compact('category_info'));
    }

    public function update(Request $request)
    {
        $category = Category::find($request->category_id);

        if (!is_null($category))
        {
            $request->validate([
                'cat_name'          => ['required'],
                'category_image'    => ['required', 'image', 'file', 'max:3000'],
            ]);

            $category->update([
                'cat_name'      => $request->cat_name,
                'auth_id'       => Auth::id(),
                'cat_desc'      => $request->cat_desc,
                'updated_at'    => Carbon::now()
            ]);

            if (!is_null($request->category_image))
            {
                if ( File::exists('backend/uploads/category/' . $category->category_image) ){
                    File::delete('backend/uploads/category/' . $category->category_image);
                }

                $image              = $request->category_image;
                $image_extention    = $image->getClientOriginalExtension();
                $image_name         = $request->category_id.'.'.$image_extention;
                $location           = public_path('backend/uploads/category/'. $image_name);

                Image::make($image)->resize(500, 333)->save($location);

                $category->update([
                    'category_image' => $image_name
                ]);
            }

            return redirect()->route('category')->with('update', 'Category has now updated.');
        }
        else {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $category = Category::find($id);

        if ( !is_null($category) )
        {
            $category->delete();

            return back()->with('delete','Category Delete..');
        }
        else {
            return redirect()->route('category');
        }
    }

    public function restore($id)
    {
        Category::onlyTrashed()->find($id)->restore();

        return back();
    }

    public function forcedel($id)
    {
        $category_id = Category::onlyTrashed()->find($id);

        if (!is_null($category_id))
        {
            $delete_id = $category_id->id;
            $subcategory_id = subcategory::where('category_id', $delete_id)->get();
            foreach ($subcategory_id as $subcat)
            {
                $subcat_id = $subcat->id;
                subcategory::find($subcat_id)->delete();
            }

            if ( File::exists('backend/uploads/category/' . $category_id->category_image) ){
                File::delete('backend/uploads/category/' . $category_id->category_image);
            }

            Category::onlyTrashed()->find($id)->forceDelete();
            return back();
        }
        else {
            return back();
        }
    }

    public function alltrash(Request $request)
    {
        if (!empty($request->cate_id))
        {
            foreach ($request->cate_id as $id)
            {
                Category::find($id)->delete();
            }
            return back();
        }
        else {
            return back();
        }
    }

    public function allrestore(Request $request)
    {
        if ($request->trashrestore == 1)
        {
            if (!empty($request->trashCate_id))
            {
                foreach ($request->trashCate_id as $id)
                {
                    Category::onlyTrashed()->find($id)->restore();
                }
                return back();
            }
            else {
                return back();
            }
        }
        elseif ($request->trashdelete == 2)
        {
            if (!empty($request->trashCate_id))
            {
                foreach ($request->trashCate_id as $id)
                {
                    $subcategory_id = subcategory::where('category_id', $id)->get();
                    foreach ($subcategory_id as $subcat)
                    {
                        $subcat_id = $subcat->id;
                        subcategory::find($subcat_id)->delete();
                    }

                    Category::onlyTrashed()->find($id)->forceDelete();
                }
                return back();
            }
            else {
                return back();
            }
        }
    }

    public function perdelete()
    {
        $checkData = Category::where('id', '>', 0)->where('deleted_at', '=', NULL)->get()->count();

        if ($checkData > 0)
        {
            $category = Category::all();
            foreach ($category as $cate)
            {
                $subcategory_id = subcategory::where('category_id', $cate->id)->get();
                foreach ($subcategory_id as $subcat)
                {
                    $subcat_id = $subcat->id;
                    subcategory::find($subcat_id)->delete();
                }

                if ( File::exists('backend/uploads/category/' . $cate->category_image) )
                {
                    File::delete('backend/uploads/category/' . $cate->category_image);
                }
            }

            Category::where('id', '>', 0)->where('deleted_at', '=', NULL)->forceDelete();
            return back();
        }
        else {
            return back();
        }
    }

    public function download()
    {
        return Excel::download(new CategoryExport, 'category.xlsx');

    }
}
