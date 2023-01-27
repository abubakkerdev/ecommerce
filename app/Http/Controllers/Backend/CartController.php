<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Cart;
use App\Models\Backend\Category;
use App\Models\Backend\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories   = Category::all();
        $customer_carts = Cart::where('customer_id', Auth::guard('customer')->id())->get();

        return view('frontend.pages.cart', compact('categories', 'customer_carts'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Cart::insert([
            'customer_id'       => Auth::guard('customer')->id(),
            'product_id'        => $request->product_id,
            'product_quantity'  => $request->product_quantity,
            'product_colorid'   => $request->product_colorid,
            'product_sizeid'    => $request->product_sizeid,
            'created_at'        => Carbon::now(),
        ]);

        return back()->with('cart_store', 'Cart Added Successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Backend\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Backend\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (isset($_POST['btn_cart']))
        {
            $cart_quantity = $request->product_quantity;

            foreach ($cart_quantity as $id => $quantity)
            {
                Cart::find($id)->update([
                    'product_quantity'  => $quantity,
                    'updated_at'        => Carbon::now()
                ]);
            }

            return back()->with('cart_update', 'Cart has now updated.');
        }
        elseif (isset($_POST['btn_coupon']))
        {
            $request->validate([
                'coupon' => 'required'
            ]);

            $coupon = Coupon::where('coupon_name', $request->coupon)->exists();
            $coupon_code = Coupon::where('coupon_name', $request->coupon)->first();

            if ($coupon)
            {
                if ($coupon_code->validity >= now()->format('Y-m-d'))
                {
                    $coupon_discount = $coupon_code->discount;
                    Session::put('coupon_discount', $coupon_discount);

                    return back();
                }
                else {
                    Session::forget('coupon_discount');
                    return back()->with('coupon_time', 'This coupon has expired!');
                }
            }
            else {
                Session::forget('coupon_discount');
                return back()->with('coupon_err', 'This coupon does not exists!');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Backend\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::findOrFail($id)->delete();
        return back();
    }
}
