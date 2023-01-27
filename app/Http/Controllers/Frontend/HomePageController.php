<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Category;
use App\Models\Backend\Color;
use App\Models\Backend\Product;
use App\Models\Backend\Size;
use App\Models\Frontend\HomePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories     = Category::all();
        $products       = Product::all();
        $sizes          = Size::all();
        $colors         = Color::all();
        $new_arrivals   = Product::latest()->take(3)->get();

        return view('frontend.pages.index', [
            'categories'    => $categories,
            'products'      => $products,
            'sizes'         => $sizes,
            'colors'        => $colors,
            'new_arrivals'  => $new_arrivals,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('welcome');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        return view('frontend.pages.products.check');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Frontend\HomePage  $homePage
     * @return \Illuminate\Http\Response
     */
    public function email($name,$email)
    {
        echo $name;
        echo "<br>";
        echo $email;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Frontend\HomePage  $homePage
     * @return \Illuminate\Http\Response
     */
    public function edit(HomePage $homePage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Frontend\HomePage  $homePage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HomePage $homePage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Frontend\HomePage  $homePage
     * @return \Illuminate\Http\Response
     */
    public function delme()
    {
        $product = Product::find(4000);

        echo (isset($product->id) ? $product->id : NULL);
    }
}
