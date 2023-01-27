<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Category;
use App\Models\Backend\Size;
use App\Models\Backend\Color;
use App\Models\Backend\Inventory;
use App\Models\Backend\Product as BackendProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Product extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $categories         = Category::all();
        $product            = BackendProduct::find($id);
        $sizes              = Size::all();
        $colors             = Color::all();
        $related_products   = BackendProduct::where('category_id',$product->category_id)->where('id', '!=', $id)->get();

        $available_colors   = Inventory::where('product_id', $id)->groupBy('color_id')->selectRaw('sum(color_id) as color, color_id')->get();
        $exist_size         = Inventory::where('product_id', $id)->where('size_id', 7)->exists();

        return view('frontend.pages.products.details', [
            'categories'        => $categories,
            'product'           => $product,
            'sizes'             => $sizes,
            'colors'            => $colors,
            'related_products'  => $related_products,
            'available_colors'  => $available_colors,
            'exist_size'        => $exist_size,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getsize(Request $request)
    {
        $id = $request->color_id;

        $available_size   = Inventory::where('product_id', $request->product_id)->where('color_id', $id)->get();

        $option = '<option value="">- Please select -</option><option value="">Choose A Option</option>';
        foreach ($available_size as $size)
        {
            $option .= '<option value="'.$size->rel_to_size->id.'">'.$size->rel_to_size->size_name.'</option>';
        }

        return response()->json($option);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
