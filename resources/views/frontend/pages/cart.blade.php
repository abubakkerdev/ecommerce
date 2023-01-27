@extends('frontend.layouts.template')

@section('frontendBodyContent')
<main>
    <!-- sidebar cart - start
    ================================================== -->
    @include('frontend.includes.cart')
    <!-- sidebar cart - end
    ================================================== -->

    <!-- breadcrumb_section - start
    ================================================== -->
    <div class="breadcrumb_section">
        <div class="container">
            <ul class="breadcrumb_nav ul_li">
                <li><a href="{{ route('home.page') }}">Home</a></li>
                <li>Cart</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb_section - end
    ================================================== -->


    <!-- cart_section - start
    ================================================== -->
    <section class="cart_section section_space">
        <div class="container">

            <div class="cart_table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $customer_productPrice = 0;
                        @endphp
                        @foreach ($customer_carts as $customer_cart)
                            <tr>
                                <td>
                                    <div class="cart_product">
                                        <img src="{{ asset('backend/uploads/product/preview/'.$customer_cart->product_info->product_preview) }}" alt="image_not_found">
                                        <h3><a href="{{ route('product.index',$customer_cart->product_id) }}" target="_blank">{{ $customer_cart->product_info->product_name }}</a></h3>
                                    </div>
                                </td>
                                <td class="text-center custom_codeQuantity"><span class="price_text">${{ ($customer_cart->product_info->discount) ? $customer_cart->product_info->after_discount : $customer_cart->product_info->product_price }}</span></td>
                                <td class="text-center custom_codeQuantity">
                                    <form action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        <div class="quantity_input">
                                            <button data-deprice="{{ ($customer_cart->product_info->discount) ? $customer_cart->product_info->after_discount : $customer_cart->product_info->product_price }}" type="button" class="input_number_decrement">
                                                <i data-dprice="{{ ($customer_cart->product_info->discount) ? $customer_cart->product_info->after_discount : $customer_cart->product_info->product_price }}" class="fal fa-minus"></i>
                                            </button>
                                            <input class="input_numberChange" type="text" name="product_quantity[{{ $customer_cart->id }}]" readonly value="{{ $customer_cart->product_quantity }}" />
                                            <button data-inprice="{{ ($customer_cart->product_info->discount) ? $customer_cart->product_info->after_discount : $customer_cart->product_info->product_price }}" type="button" class="input_number_increment">
                                                <i data-price="{{ ($customer_cart->product_info->discount) ? $customer_cart->product_info->after_discount : $customer_cart->product_info->product_price }}" class="fal fa-plus"></i>
                                            </button>
                                        </div>
                                </td>

                                <td class="text-center custom_codeQuantity">
                                    <span class="price_text">${{ ($customer_cart->product_info->discount) ? ($customer_cart->product_info->after_discount)*$customer_cart->product_quantity : ($customer_cart->product_info->product_price) *$customer_cart->product_quantity }}</span></td>
                                <td class="text-center">
                                    <a href="{{ route('cart.delete', $customer_cart->id) }}" class="remove_btn">
                                        <i class="fal fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            @php
                                $customer_productPrice += (($customer_cart->product_info->discount) ? ($customer_cart->product_info->after_discount)*$customer_cart->product_quantity : ($customer_cart->product_info->product_price) *$customer_cart->product_quantity);
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="cart_btns_wrap">
                <div class="row">
                    <div class="col col-lg-6">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="coupon_form form_item mb-0">
                                    <input type="text" name="coupon" value="{{ old('coupon') }}" placeholder="Coupon Code...">
                                    <button type="submit" name="btn_coupon" class="btn btn_dark">Apply Coupon</button>

                                    <div class="info_icon">
                                        <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Your Info Here"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                @error('coupon')
                                    <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @enderror
                                @if (session()->has('coupon_err'))
                                    <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                                        {{ session()->get('coupon_err') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @elseif (session()->has('coupon_time'))
                                    <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                                        {{ session()->get('coupon_time') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col col-lg-6">
                        <ul class="btns_group ul_li_right">
                            <li><button type="submit" name="btn_cart" class="btn border_black">Update Cart</button></li>
                        </form>
                            <li><a class="btn btn_dark" href="{{ route('checkout.index') }}">Prceed To Checkout</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col col-lg-12">
                    <div class="cart_total_table">
                        <h3 class="wrap_title">Cart Totals</h3>
                        @php
                            if (Session::get('coupon_discount'))
                            {
                                $coupon_discount = Session::get('coupon_discount');
                                $after_couponDiscount = $customer_productPrice*($coupon_discount/100);
                                $grand_total = ($customer_productPrice - $after_couponDiscount);
                            }
                            else {
                                $coupon_discount = 0;
                                $after_couponDiscount = $customer_productPrice*($coupon_discount/100);
                                $grand_total = ($customer_productPrice - $after_couponDiscount);
                            }

                            session(['code_discount' => $coupon_discount]);
                        @endphp
                        <ul class="ul_li_block">
                            <li>
                                <span>Cart Subtotal</span>
                                <span>${{ $customer_productPrice }}</span>
                            </li>
                            <li>
                                <span>Discount</span>
                                <span>
                                    {{ $coupon_discount }}%
                                </span>
                            </li>
                            <li>
                                <span>Discount Amount</span>
                                <span>
                                    ${{ $after_couponDiscount }}
                                </span>
                            </li>
                            <li>
                                <span>Order Total</span>
                                <span>${{ $grand_total }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- cart_section - end
    ================================================== -->


    <!-- newsletter_section - start
    ================================================== -->
    <section class="newsletter_section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col col-lg-6">
                    <h2 class="newsletter_title text-white">Sign Up for Newsletter </h2>
                    <p>Get E-mail updates about our latest products and special offers.</p>
                </div>
                <div class="col col-lg-6">
                    <form action="#!">
                        <div class="newsletter_form">
                            <input type="email" name="email" placeholder="Enter your email address">
                            <button type="submit" class="btn btn_secondary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- newsletter_section - end
    ================================================== -->
</main>
@endsection

@section('footerScript')
    <script>
        let product_quantity = document.querySelectorAll('.custom_codeQuantity');
        let quantity_arr = Array.from(product_quantity);

        quantity_arr.map(item => {
            item.addEventListener('click', function (e) {
                if (e.target.className == 'fal fa-plus')
                {
                    e.target.parentElement.previousElementSibling.value++;
                    let cart_quantity = e.target.parentElement.previousElementSibling.value;
                    let product_price = e.target.dataset.price;

                    item.nextElementSibling.innerHTML = '<span class="price_text">$'+product_price*cart_quantity+'</span>';
                }
                else if (e.target.className == 'input_number_increment')
                {
                    e.target.previousElementSibling.value++;
                    let cart_quantity = e.target.previousElementSibling.value;
                    let product_price = e.target.dataset.inprice;

                    item.nextElementSibling.innerHTML = '<span class="price_text">$'+product_price*cart_quantity+'</span>';
                }


                if (e.target.className == 'fal fa-minus')
                {
                    if (e.target.parentElement.nextElementSibling.value > 1)
                    {
                        e.target.parentElement.nextElementSibling.value--;
                        let cart_quantity = e.target.parentElement.nextElementSibling.value;
                        let product_price = e.target.dataset.dprice;

                        item.nextElementSibling.innerHTML = '<span class="price_text">$'+product_price*cart_quantity+'</span>';
                        // e.target.parentElement.setAttribute('disabled', true);
                        // e.target.setAttribute('disabled', true);
                    }
                }
                else if (e.target.className == 'input_number_decrement')
                {
                    if (e.target.nextElementSibling.value > 1)
                    {
                        e.target.nextElementSibling.value--;
                        let cart_quantity = e.target.nextElementSibling.value;
                        let product_price = e.target.dataset.deprice;
                        item.nextElementSibling.innerHTML = '<span class="price_text">$'+product_price*cart_quantity+'</span>';
                    }
                }
            });
        });
    </script>

    @if (session()->has('cart_update'))
        <script>
            $.toast({
                heading: 'Update successful',
                text: '{{ session()->get("cart_update") }}',
                icon: 'info',
                position: 'top-right',
                hideAfter: 2500,
                showHideTransition: 'slide'
            });
        </script>
    @endif
@endsection
