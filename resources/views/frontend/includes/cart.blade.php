<div class="sidebar-menu-wrapper">
    <div class="cart_sidebar">
        <button type="button" class="close_btn"><i class="fal fa-times"></i></button>
        <ul class="cart_items_list ul_li_block mb_30 clearfix">
            @php
                $sub = 0;
            @endphp
            @foreach (App\Models\Backend\Cart::where('customer_id',Auth::guard('customer')->id())->get() as $cart)
                <li>
                    <div class="item_image">
                        <img src="{{ asset('backend/uploads/product/preview/'.$cart->product_info->product_preview) }}" alt="image_not_found">
                    </div>
                    <div class="item_content">
                        <h4 class="item_title">{{ $cart->product_info->product_name }}</h4>
                        <span class="item_price">${{ ($cart->product_info->discount) ? $cart->product_info->after_discount : $cart->product_info->product_price }} &nbsp;({{ $cart->product_quantity }})</span>
                    </div>
                    <a href="{{ route('cart.delete', $cart->id) }}" class="remove_btn"><i class="fal fa-trash-alt"></i></a>
                </li>
                @php
                    $sub += (($cart->product_info->discount) ? $cart->product_info->after_discount : $cart->product_info->product_price)*$cart->product_quantity;
                @endphp
            @endforeach
        </ul>

        <ul class="total_price ul_li_block mb_30 clearfix">
            <li>
                <span>Total:</span>
                <span>${{ $sub }}</span>
            </li>
        </ul>

        <ul class="btns_group ul_li_block clearfix">
            <li><a class="btn btn_primary" href="{{ route('cart.index') }}">View Cart</a></li>
            {{-- <li><a class="btn btn_secondary" href="checkout.html">Checkout</a></li> --}}
        </ul>
    </div>

    <div class="cart_overlay"></div>
</div>
