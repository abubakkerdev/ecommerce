<?php

namespace App\Mail;

use App\Models\Frontend\BillingDetail;
use App\Models\Frontend\Customer;
use App\Models\Frontend\Order;
use App\Models\Frontend\OrderProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $customer_orderId;

    protected $order_info;
    protected $user_info;
    protected $billing_info;
    protected $product_info;
    protected $product_lastId;

    public function __construct($id)
    {
        $this->customer_orderId = $id;

        $this->order_info       = Order::find($id);
        $this->user_info        = Customer::find($this->order_info->user_id);
        $this->billing_info     = BillingDetail::where('order_id', $id)->first();
        $this->product_info     = OrderProduct::where('order_id', $id)->get();
        $this->product_lastId   = OrderProduct::where('order_id', $id)->latest('id')->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'order_info'        => $this->order_info,
            'billing_info'      => $this->billing_info,
            'user_info'         => $this->user_info,
            'product_info'      => $this->product_info,
            'product_lastId'    => $this->product_lastId,
        ];

        return $this->view('frontend.pages.customer.invoice-mail', $data);
    }
}
