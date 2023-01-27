<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Category;
use App\Models\Backend\Inventory;
use App\Models\Backend\Product;
use App\Models\Backend\ProductThumbnail;
use App\Models\Backend\subcategory;
use App\Rules\ImageExtensionValidate;
use App\Rules\Imagefilevalidate;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('backend.pages.product.manage', [
            'products'  => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category       = Category::orderBy('cat_name', 'ASC')->get();
        $subcategory    = subcategory::orderBy('subcat_name', 'ASC')->get();

        return view('backend.pages.product.create', [
            'category'      => $category,
            'subcategory'   => $subcategory,
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
            'product_name'      => ['required', 'unique:products'],
            'product_desc'      => ['required'],
            'short_desc'        => ['required'],
            'product_brand'     => ['required'],
            'category_id'       => ['required'],
            'subcategory_id'    => ['required'],
            'product_price'     => ['required'],
            'product_preview'   => ['required', 'image', 'file', 'max:500'],
            'product_thumbnail' => ['required', new Imagefilevalidate, new ImageExtensionValidate]
        ]);

        if (!empty($request->discount))
        {
            $after_discount = $request->product_price -($request->product_price*$request->discount)/100;
        }
        else {
            $after_discount = $request->after_discount;
        }

        $product_id = Product::insertGetId([
            'product_name'      => $request->product_name,
            'product_desc'      => $request->product_desc,
            'short_desc'        => $request->short_desc,
            'product_brand'     => $request->product_brand,
            'category_id'       => $request->category_id,
            'subcategory_id'    => $request->subcategory_id,
            'product_price'     => $request->product_price,
            'discount'          => $request->discount,
            'after_discount'    => $after_discount,
            'product_preview'   => $request->product_preview,
            'created_at'        => Carbon::now(),
        ]);

        $image              = $request->product_preview;
        $image_extention    = $image->getClientOriginalExtension();
        $image_name         = $product_id.'.'.$image_extention;
        $location           = public_path('backend/uploads/product/preview/'. $image_name);

        Image::make($image)->resize(800, 609)->save($location);

        $product_img   = Product::find($product_id);
        $product_img->update([
            'product_preview' => $image_name
        ]);

        if (!empty($request->product_thumbnail))
        {
            $thumbnails  = $request->product_thumbnail;

            foreach ($thumbnails as $key => $thumbnail)
            {
                $thumbnail_extention    = $thumbnail->getClientOriginalExtension();
                $thumbnail_image_name   = $product_id.'-'.($key+1).'.'.$thumbnail_extention;
                $thumbnail_location     = public_path('backend/uploads/product/thumbnail/'. $thumbnail_image_name);

                Image::make($thumbnail)->resize(800, 609)->save($thumbnail_location);

                ProductThumbnail::insert([
                    'product_id'        => $product_id,
                    'product_thumbnail' => $thumbnail_image_name,
                    'created_at'        => Carbon::now()
                ]);
            }
        }

        return redirect()->route('product.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product_info = Product::find($id);
        return view('backend.pages.product.view', compact('product_info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product     = Product::find($id);
        $thumbnails  = ProductThumbnail::where('product_id', $id)->get();
        $category    = Category::orderBy('cat_name', 'ASC')->get();
        $subcategory = subcategory::orderBy('subcat_name', 'ASC')->get();

        return view('backend.pages.product.edit', [
            'product'       => $product,
            'thumbnails'    => $thumbnails,
            'category'      => $category,
            'subcategory'   => $subcategory
        ]);
    }

    public function thumbnails($id)
    {
        $thumbnails  = ProductThumbnail::where('product_id', $id)->get();

        $str_to_send = "";
        foreach ($thumbnails as $thumbnail)
        {
            $str_to_send .= '<div class="col-lg-4"><div class="form-row">';
            $str_to_send .= '<div class="input-group mb-2 ml-2 col-md-5">';
            $str_to_send .= '<img src="http://127.0.0.1:8000/backend/uploads/product/thumbnail/'.$thumbnail->product_thumbnail.'" width="80" class="mb-3" alt="">';
            $str_to_send .= '</div>';
            $str_to_send .= '<div class="input-group mb-3">';
            $str_to_send .= '<input type="file" name="thumbnail_'.$thumbnail->id.'" class="form-control">';
            $str_to_send .= '<input type="hidden" name="id_thumbnail[]" value="'.$thumbnail->id.'" id="thumbnail_id">';
            $str_to_send .= '<a href="#" onclick="runthumbnail('.$thumbnail->id.')" class="btn btn-danger ml-2 shadow btn-xs sharp">
            <i class="fa fa-trash"></i></a>';
            $str_to_send .= '</div>';
            $str_to_send .= '</div></div>';
        }

       return response()->json($str_to_send);
    }

    public function delthumbnail(Request $request)
    {
        $id = $request->thumbnail_id;

        $thumbnail = ProductThumbnail::find($id);

        if ( File::exists('backend/uploads/product/thumbnail/' . $thumbnail->product_thumbnail) )
        {
            File::delete('backend/uploads/product/thumbnail/' . $thumbnail->product_thumbnail);
        }

        $thumbnail->delete();

        return response()->json();
    }

    /**
     * code here ....
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $thumbnail = $request->product_id;
        $request->validate([
            'product_name'      => ['required', Rule::unique('products')->ignore($thumbnail) ],
            'product_desc'      => ['required'],
            'short_desc'        => ['required'],
            'product_brand'     => ['required'],
            'category_id'       => ['required'],
            'subcategory_id'    => ['required'],
            'product_price'     => ['required'],
            'product_preview'   => ['image', 'file', 'max:500'],
        ]);

        $thumbnails = ProductThumbnail::where('product_id', $thumbnail)->get();

        if (!empty($request->discount))
        {
            $after_discount = $request->product_price -($request->product_price*$request->discount)/100;
        }
        else {
            $after_discount = $request->after_discount;
        }

        Product::find($thumbnail)->update([
            'product_name'      => $request->product_name,
            'product_desc'      => $request->product_desc,
            'short_desc'        => $request->short_desc,
            'product_brand'     => $request->product_brand,
            'category_id'       => $request->category_id,
            'subcategory_id'    => $request->subcategory_id,
            'product_price'     => $request->product_price,
            'discount'          => $request->discount,
            'after_discount'    => $after_discount,
            'updated_at'        => Carbon::now(),
        ]);


        if (!empty($request->product_preview))
        {
            $preview_img = $request->product_preview->getClientOriginalExtension();
            $preview_img_name   = $thumbnail.'.'.$preview_img;
            $preview_img_location     = public_path('backend/uploads/product/preview/'. $preview_img_name);

            Image::make($request->product_preview)->resize(800, 609)->save($preview_img_location);

            Product::find($thumbnail)->update([
                'product_preview' => $preview_img_name,
                'updated_at'      => Carbon::now()
            ]);
        }

        if (!empty($request->product_thumbnail))
        {
            $thumbnail_new = $request->product_thumbnail;
            $info_thumb    = ProductThumbnail::where('product_id', $thumbnail)->get();

            if (count($info_thumb) == 0)
            {
                $img_prefix = 1;
            }
            else {
                $last_value = $info_thumb->last();
                $explode_one = explode('.', $last_value->product_thumbnail);
                $explode_two = explode('-', $explode_one[0]);

                $img_prefix = $explode_two[1]+1;
            }

            foreach ($thumbnail_new as $thumbnailImg)
            {
                $thum_extention    = $thumbnailImg->getClientOriginalExtension();
                $thum_image        = $thumbnail.'-'.($img_prefix).'.'.$thum_extention;
                $thum_location     = public_path('backend/uploads/product/thumbnail/'. $thum_image);

                Image::make($thumbnailImg)->resize(800, 609)->save($thum_location);

                ProductThumbnail::insert([
                    'product_id'        => $thumbnail,
                    'product_thumbnail' => $thum_image,
                    'created_at'        => Carbon::now()
                ]);
                $img_prefix++;
            }
        }


        foreach ($thumbnails as $key => $thumbna)
        {
            $name = 'thumbnail_'.$thumbna->id;

            if (!empty($request->$name))
            {
                $thumbnail_id = $thumbna->id;
                $thumbnail_info = ProductThumbnail::find($thumbnail_id);

                $number     = explode('-', $thumbnail_info->product_thumbnail);
                $number_end = end($number);
                $explode    = explode('.', $number_end);

                $thumbnail_extention    = $request->$name->getClientOriginalExtension();
                $thumbnail_image_name   = $thumbnail.'-'.($explode[0]).'.'.$thumbnail_extention;
                $thumbnail_location     = public_path('backend/uploads/product/thumbnail/'. $thumbnail_image_name);

                if ( File::exists('backend/uploads/product/thumbnail/' . $thumbnail_info->product_thumbnail) )
                {
                    File::delete('backend/uploads/product/thumbnail/' . $thumbnail_info->product_thumbnail);
                }

                Image::make($request->$name)->resize(800, 609)->save($thumbnail_location);

                $thumbnail_info->update([
                    'product_thumbnail'  => $thumbnail_image_name,
                    'updated_at'         => Carbon::now()
                ]);

            }
        }

        return back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function subcategory(Request $request)
    {
        $id = $request->category_id;
        $subcategory = subcategory::where('category_id', $id)->get();
        $str_to_send = '<option value="">Select Subcategory</option>';

        foreach ($subcategory as $subcat)
        {
            $str_to_send .= '<option value="'.$subcat->id.'">'.$subcat->subcat_name.'</option>';
        }

        return response()->json($str_to_send);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $thumbnail_info = ProductThumbnail::where('product_id', $id)->get();
        $product_info   = Product::find($id);
        $inventory_info = Inventory::where('product_id', $id)->get();

        foreach ($inventory_info as $inventory)
        {
            Inventory::find($inventory->id)->delete();
        }

        foreach ($thumbnail_info as $thumbnail)
        {
            $img = $thumbnail->product_thumbnail;

            if ( File::exists('backend/uploads/product/thumbnail/'.$img) ){
                File::delete('backend/uploads/product/thumbnail/'.$img);
            }

            ProductThumbnail::find($thumbnail->id)->delete();
        }

        if ( File::exists('backend/uploads/product/preview/'.$product_info->product_preview) ){
            File::delete('backend/uploads/product/preview/'.$product_info->product_preview);
        }

        $product_info->delete();

        return back()->with('delete_product', 'defalut');
    }

}
