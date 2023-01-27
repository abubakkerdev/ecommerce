<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerify;
use App\Models\Frontend\Customer;
use App\Models\Backend\Category;
use App\Models\Frontend\BillingDetail;
use App\Models\Frontend\Order;
use App\Models\Frontend\OrderProduct;
use App\Mail\InvoiceMail;
use App\Models\CustomerPasswordReset;
use App\Models\Frontend\CustomerEmailVerify;
use App\Notifications\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\Password as RulesPassword;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories     = Category::all();
        return view('frontend.pages.customer.register', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => ['required', 'unique:customers'],
            'password'  => ['required', RulesPassword::min(8)->letters()->mixedCase()->numbers()->symbols(), 'confirmed'],
            'password_confirmation' => ['required'],
        ]);

        $customer_id = Customer::insertGetId([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'created_at'    => Carbon::now()
        ]);

        CustomerEmailVerify::insert([
            'customer_id'   => $customer_id,
            'token'         => $request->_token,
            'created_at'    => Carbon::now("Asia/Dhaka")
        ]);

        Mail::to($request->email)->send(new EmailVerify($request->_token));

        return back();
    }

    public function email_verify($token)
    {
        $check = CustomerEmailVerify::firstWhere('token', $token);

        if (!empty($check))
        {
            $customer = Customer::find($check->customer_id);

            $customer->update([
                'email_verify' => Carbon::now("Asia/Dhaka"),
            ]);

            Auth::guard('customer')->login($customer);

            $check->delete();

            return redirect()->route('customer.profile');
        }
        else {
            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function customer_login(Request $request)
    {
        $request->validate([
            'email'     => ['required'],
            'password'  => ['required'],
        ]);

        $customer = Customer::firstWhere('email', $request->email);

        if (!empty($customer))
        {
            if(!Hash::check($request->password, $customer->password))
            {
                return back()->with('password', 'Password does not match..!');
            }
            else {

                if (!empty($customer->email_verify))
                {
                    if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password]))
                    {
                        return redirect()->route('customer.profile');
                    }
                }
                else {
                    return back();
                }
            }
        }
        else {
            return back()->with('email', 'Email does not exists..!');
        }



        // if (Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password]))
        // {
        //     return redirect()->route('customer.profile');
        // }
        // else {
        //     return back();
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Frontend\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $categories     = Category::all();
        $order          = Order::all();
        return view('frontend.pages.customer.profile', compact('categories', 'order'));
    }

    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect('/customer/register');
    }

    public function mail($id)
    {
        $order = Order::find($id);
        $user = Customer::find($order->user_id);

        Mail::to($user->email)->send(new InvoiceMail($id));

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Frontend\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function invoice($id)
    {
        $order_info = Order::find($id);
        $user_info = Customer::find($order_info->user_id);
        $billing_info = BillingDetail::where('order_id', $id)->first();
        $product_info = OrderProduct::where('order_id', $id)->get();
        $product_lastId = OrderProduct::where('order_id', $id)->latest('id')->first();

        $data = [
            'order_info'        => $order_info,
            'billing_info'      => $billing_info,
            'user_info'         => $user_info,
            'product_info'      => $product_info,
            'product_lastId'    => $product_lastId,
        ];

        $pdf_name = 'invoice'.'-'.$id.'.pdf';
        $pdf = PDF::loadView('frontend.pages.customer.invoice', $data);

        return $pdf->stream($pdf_name);

        // return $pdf->download($pdf_name);
        // return view('frontend.pages.customer.invoice', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Frontend\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name'      => 'required',
        ]);

        if (!is_null($request->password))
        {
            $request->validate([
                'name'      => 'required',
                'password'  => ['required', RulesPassword::min(8)->letters()->mixedCase()->numbers()->symbols(), 'confirmed'],
            ]);
        }

        $customer = Customer::find(Auth::guard('customer')->id());

        $customer->update([
            'name'          => $request->name,
            'password'      => Hash::make($request->password),
            'updated_at'    => Carbon::now()
        ]);

        return back()->with('profile-update', 'Profile updated successfully!');
    }


    // password reset start
    public function password_reset()
    {
        $categories     = Category::all();
        return view('frontend.pages.customer.password-reset', compact('categories'));
    }

    public function token_store(Request $request)
    {
        $customer_info = Customer::where('email', $request->email)->first();

        if (empty($customer_info->id))
        {
            return back();
        }
        else {

            if (CustomerPasswordReset::where('customer_id', $customer_info->id)->exists())
            {
                CustomerPasswordReset::where('customer_id', $customer_info->id)->delete();
            }

            $customer = CustomerPasswordReset::create([
                'customer_id' => $customer_info->id,
                'token'       => uniqid(),
                'created_at'  => Carbon::now('Asia/Dhaka')
            ]);

            Notification::send($customer_info, new PasswordReset($customer));

            return back();
        }
    }

    public function password_change($token)
    {
        $categories     = Category::all();
        $check_token    = CustomerPasswordReset::where('token', $token)->first();

        if ($check_token)
        {
            return view('frontend.pages.customer.password-change', compact('categories', 'token'));
        }
        else {
            return redirect('/customer/register');
        }
    }

    public function password_store(Request $request)
    {
        $user = CustomerPasswordReset::where('token', $request->token)->first();
        $customer = Customer::find($user->customer_id);
        $customer->update([
            'password'      => bcrypt($request->password),
            'updated_at'    => Carbon::now()
        ]);

        Auth::guard('customer')->attempt(['email' => $customer->email, 'password' => $request->password]);

        $user->delete();

        return redirect('/customer/register');
    }
    // password reset end


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Frontend\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $categories     = Category::all();

        return view('frontend.pages.stripe-design', [
            'categories'    => $categories,
        ]);
    }
}
