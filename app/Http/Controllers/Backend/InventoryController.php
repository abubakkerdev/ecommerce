<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Color;
use App\Models\Backend\Inventory;
use App\Models\Backend\Product;
use App\Models\Backend\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $product    = Product::find($id);
        $colors     = Color::all();
        $sizes      = Size::all();
        $inventory  = Inventory::where('product_id', $id)->get();

        return view('backend.pages.inventory.manage', [
            'product'   => $product,
            'colors'    => $colors,
            'sizes'     => $sizes,
            'inventory' => $inventory
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $colors     = Color::all();
        $sizes      = Size::all();
        $products   = Product::all();
        return view('backend.pages.inventory.create', [
            'colors' => $colors,
            'sizes' => $sizes,
            'products' => $products
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
        if (Inventory::where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists())
        {
            Inventory::where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('product_quality', $request->product_quality);
        }
        else {
            Inventory::insert([
                'product_id'        => $request->product_id,
                'color_id'          => $request->color_id,
                'size_id'           => $request->size_id,
                'product_quality'   => $request->product_quality,
                'created_at'        => Carbon::now()
            ]);
        }

        return back()->with('invenStore', 'Inventory has now create.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Backend\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show_all_inventory(Inventory $inventory)
    {
        $inventory  = Inventory::all();
        return view('backend.pages.inventory.inventory-manage', [
            'inventory' => $inventory,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Backend\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventory_info = Inventory::find($id);
        $colors         = Color::all();
        $sizes          = Size::all();
        $products       = Product::all();

        return view('backend.pages.inventory.edit', [
            'inventory_info' => $inventory_info,
            'colors'         => $colors,
            'sizes'          => $sizes,
            'products'       => $products
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Backend\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id'        => 'required',
            'product_quality'   => 'required',
        ]);

        Inventory::find($request->inventory_id)->update([
            'product_id'        => $request->product_id,
            'color_id'          => $request->color_id,
            'size_id'           => $request->size_id,
            'product_quality'   => $request->product_quality,
            'updated_at'        => Carbon::now(),
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Backend\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Inventory::find($id)->delete();

        return back()->with('delete_inventory','Inventory Delete..');
    }

    public function color()
    {
        $colors = Color::all();
        return view('backend.pages.product.color', [
            'colors' => $colors
        ]);
    }

    public function  color_delete($id)
    {
        Color::find($id)->delete();
        return back()->with('delete_color', 'default');
    }

    public function colorStore(Request $request)
    {
        $request->validate([
            'color_name' => 'required'
        ]);

        Color::insert([
            'color_name'   => $request->color_name,
            'created_at'   => Carbon::now()
        ]);

        return back()->with('store', 'Color has now create.');
    }

    public function size()
    {
        $all_size = Size::all();
        return view('backend.pages.product.size', [
            'all_size' => $all_size
        ]);
    }

    public function sizeStore(Request $request)
    {
        $request->validate([
            'size_name' => 'required'
        ]);

        Size::insert([
            'size_name'   => $request->size_name,
            'created_at'  => Carbon::now()
        ]);

        return back()->with('store', 'Size has now create.');
    }

    public function  size_delete($id)
    {
        Size::find($id)->delete();
        return back()->with('delete_size', 'default');
    }
}
