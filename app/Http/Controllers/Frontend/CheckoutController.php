<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Cart;
use App\Models\Backend\Category;
use App\Models\Backend\Inventory;
use App\Models\Frontend\BillingDetail;
use App\Models\Frontend\Checkout;
use App\Models\Frontend\City;
use App\Models\Frontend\Country;
use App\Models\Frontend\Order;
use App\Models\Frontend\OrderProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts         = Cart::where('customer_id',Auth::guard('customer')->id())->get();
        $categories     = Category::all();
        $customer_carts = Cart::where('customer_id', Auth::guard('customer')->id())->get();
        $countries      = Country::all();
        $cities         = City::all();
        $subtotal       = 0;

        foreach ($carts as $item_price)
        {
            $subtotal += (($item_price->product_info->discount) ? $item_price->product_info->after_discount : $item_price->product_info->product_price)*$item_price->product_quantity;
        }

        return view('frontend.pages.checkout', [
            'categories'        => $categories,
            'customer_carts'    => $customer_carts,
            'countries'         => $countries,
            'cities'            => $cities,
            'subtotal'          => $subtotal,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request)
    {
        $request->validate([
            'payment_method'    => 'required',
            'delivery_charge'   => 'required'
        ]);

        if ($request->payment_method == 1)
        {
            $total_price = $request->order_total - ($request->order_total*$request->order_discount)/100 +($request->delivery_charge);
            $carts = Cart::where('customer_id',Auth::guard('customer')->id())->get();

            $order_id = Order::insertGetId([
                'user_id'           => Auth::guard('customer')->id(),
                'total'             => $total_price,
                'discount'          => $request->order_discount,
                'delivery_charge'   => $request->delivery_charge,
                'payment_method'    => $request->payment_method,
                'created_at'        => Carbon::now()
            ]);

            BillingDetail::insert([
                'order_id'      => $order_id,
                'user_id'       => Auth::guard('customer')->id(),
                'name'          => $request->name,
                'email'         => $request->email,
                'company'       => $request->company,
                'phone'         => $request->phone,
                'country_id'    => $request->country_id,
                'city_id'       => $request->city_id,
                'address'       => $request->address,
                'notes'         => $request->order_note,
                'created_at'    => Carbon::now()
            ]);

            foreach ($carts as $cart)
            {
                $cart_productPrice = ($cart->product_info->discount) ? $cart->product_info->after_discount : $cart->product_info->product_price;

                OrderProduct::insert([
                    'order_id'          => $order_id,
                    'product_id'        => $cart->product_id,
                    'product_name'      => $cart->product_info->product_name,
                    'color_id'          => $cart->product_colorid,
                    'size_id'           => $cart->product_sizeid,
                    'product_price'     => $cart_productPrice,
                    'product_quantity'  => $cart->product_quantity,
                    'created_at'        => Carbon::now()
                ]);

                if (Inventory::where('color_id', $cart->product_colorid)->where('size_id', $cart->product_sizeid)->exists())
                {
                    Inventory::where('color_id', $cart->product_colorid)->where('size_id', $cart->product_sizeid)->decrement('product_quality', $cart->product_quantity);
                }

                // $cart->delete();
            }

            // Mail::to($request->email)->send(new InvoiceMail($order_id));



            $url    = "http://66.45.237.70/api.php";
            $number = $request->phone;
            $text   = "Thank you for purchasing our products.(Alpha)";
            // $data   = array(
            //     'username'=>"ababukkerDev",
            //     'password'=>"7DY65AXG",
            //     'number'=>"$number",
            //     'message'=>"$text"
            // );

            // $ch = curl_init(); // Initialize cURL
            // curl_setopt($ch, CURLOPT_URL,$url);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // $smsresult = curl_exec($ch);
            // $p = explode("|",$smsresult);
            // $sendstatus = $p[0];


            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.sms.net.bd/sendsms',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS => array('api_key' => 'rcMIM3bZZ69LIt86ijbTkKeCk0bM3aj6j6eMjpgS','msg' => $text,'to' => $number),
            ));

            $response = curl_exec($curl);

            curl_close($curl);



            Session::forget('code_discount');
            return back();
        }
        elseif ($request->payment_method == 2)
        {
            $cartdata = $request->all();

            Session::put('cartInfo', $cartdata);

            return view('exampleHosted', compact('cartdata'));
        }
        elseif ($request->payment_method == 3)
        {
            $cartdata_stripe = $request->all();

            Session::put('cartInfo_stripe', $cartdata_stripe);

            return view('frontend.pages.stripe', compact('cartdata_stripe'));
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getcity(Request $request)
    {
        $id = $request->country_id;

        $cities   = City::where('country_id', $id)->get();

        $option = '<option value="">- Please select -</option>';
        foreach ($cities as $city)
        {
            $option .= '<option value="'.$city->id.'">'.$city->name.'</option>';
        }

        return response()->json($option);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Frontend\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function confirm()
    {
        $carts         = Cart::where('customer_id',Auth::guard('customer')->id())->get();
        $categories    = Category::all();

        if (Session::get('trans_two') || Session::get('trans_one'))
        {
            $cartdata = Session::get('cartInfo');
            $total_price = $cartdata['order_total'] - ($cartdata['order_total']*$cartdata['order_discount'])/100 +($cartdata['delivery_charge']);

            $order_id = Order::insertGetId([
                'user_id'           => Auth::guard('customer')->id(),
                'total'             => $total_price,
                'discount'          => $cartdata['order_discount'],
                'delivery_charge'   => $cartdata['delivery_charge'],
                'payment_method'    => $cartdata['payment_method'],
                'created_at'        => Carbon::now()
            ]);

            BillingDetail::insert([
                'order_id'      => $order_id,
                'user_id'       => Auth::guard('customer')->id(),
                'name'          => $cartdata['name'],
                'email'         => $cartdata['email'],
                'company'       => $cartdata['company'],
                'phone'         => $cartdata['phone'],
                'country_id'    => $cartdata['country_id'],
                'city_id'       => $cartdata['city_id'],
                'address'       => $cartdata['address'],
                'notes'         => $cartdata['order_note'],
                'created_at'    => Carbon::now()
            ]);

            foreach ($carts as $cart)
            {
                $cart_productPrice = ($cart->product_info->discount) ? $cart->product_info->after_discount : $cart->product_info->product_price;

                OrderProduct::insert([
                    'order_id'          => $order_id,
                    'product_id'        => $cart->product_id,
                    'product_name'      => $cart->product_info->product_name,
                    'color_id'          => $cart->product_colorid,
                    'size_id'           => $cart->product_sizeid,
                    'product_price'     => $cart_productPrice,
                    'product_quantity'  => $cart->product_quantity,
                    'created_at'        => Carbon::now()
                ]);

                if (Inventory::where('color_id', $cart->product_colorid)->where('size_id', $cart->product_sizeid)->exists())
                {
                    Inventory::where('color_id', $cart->product_colorid)->where('size_id', $cart->product_sizeid)->decrement('product_quality', $cart->product_quantity);
                }

                $cart->delete();
            }

            Session::forget('code_discount');

            return view('frontend.pages.products.confirm', [
                'carts'         => $carts,
                'categories'    => $categories
            ]);
        }
        else {
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Frontend\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function success()
    {
        $carts         = Cart::where('customer_id',Auth::guard('customer')->id())->get();
        $categories    = Category::all();

        if (Session::get('trans_three'))
        {
            $cartdata = Session::get('cartInfo_stripe');
            $total_price = $cartdata['order_total'] - ($cartdata['order_total']*$cartdata['order_discount'])/100 +($cartdata['delivery_charge']);

            $order_id = Order::insertGetId([
                'user_id'           => Auth::guard('customer')->id(),
                'total'             => $total_price,
                'discount'          => $cartdata['order_discount'],
                'delivery_charge'   => $cartdata['delivery_charge'],
                'payment_method'    => $cartdata['payment_method'],
                'created_at'        => Carbon::now()
            ]);

            BillingDetail::insert([
                'order_id'      => $order_id,
                'user_id'       => Auth::guard('customer')->id(),
                'name'          => $cartdata['name'],
                'email'         => $cartdata['email'],
                'company'       => $cartdata['company'],
                'phone'         => $cartdata['phone'],
                'country_id'    => $cartdata['country_id'],
                'city_id'       => $cartdata['city_id'],
                'address'       => $cartdata['address'],
                'notes'         => $cartdata['order_note'],
                'created_at'    => Carbon::now()
            ]);

            foreach ($carts as $cart)
            {
                $cart_productPrice = ($cart->product_info->discount) ? $cart->product_info->after_discount : $cart->product_info->product_price;

                OrderProduct::insert([
                    'order_id'          => $order_id,
                    'product_id'        => $cart->product_id,
                    'product_name'      => $cart->product_info->product_name,
                    'color_id'          => $cart->product_colorid,
                    'size_id'           => $cart->product_sizeid,
                    'product_price'     => $cart_productPrice,
                    'product_quantity'  => $cart->product_quantity,
                    'created_at'        => Carbon::now()
                ]);

                if (Inventory::where('color_id', $cart->product_colorid)->where('size_id', $cart->product_sizeid)->exists())
                {
                    Inventory::where('color_id', $cart->product_colorid)->where('size_id', $cart->product_sizeid)->decrement('product_quality', $cart->product_quantity);
                }

                $cart->delete();
            }

            Session::forget('code_discount');

            return view('frontend.pages.products.confirm', [
                'carts'         => $carts,
                'categories'    => $categories
            ]);
        }
        else {
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Frontend\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Frontend\Checkout  $checkout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checkout $checkout)
    {
        //
    }
}
