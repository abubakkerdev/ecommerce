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
                    <li>Check Out</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb_section - end
        ================================================== -->

        {{ Session::forget('cartInfo') }}
        {{ Session::forget('cartInfo_stripe') }}

        <!-- checkout-section - start
        ================================================== -->
        <section class="checkout-section section_space">
            <div class="container">
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="woocommerce bg-light p-3">
                        <form class="checkout woocommerce-checkout" action="{{ route('checkout.order') }}" method="POST">
                            @csrf
                            <div class="col2-set" id="customer_details">
                                <div class="coll-1">
                                    <div class="woocommerce-billing-fields">
                                    <h3>Billing Details</h3>
                                    <p class="form-row form-row form-row-first validate-required" id="billing_first_name_field">
                                        <label for="name">Name <abbr class="required" title="required">*</abbr></label>
                                        <input type="text" class="input-text " name="name" id="name" value="{{ Auth::guard('customer')->user()->name }}" />
                                    </p>
                                    <p class="form-row form-row form-row-last validate-required validate-email" id="email">
                                        <label for="email">Email Address <abbr class="required" title="required">*</abbr></label>
                                        <input type="email" class="input-text" id="email" name="email" readonly value="{{ Auth::guard('customer')->user()->email }}" />
                                    </p>
                                    <div class="clear"></div>
                                    <p class="form-row form-row form-row-first" id="billing_company_field">
                                        <label for="billing_company" class="">Company Name</label>
                                        <input type="text" class="input-text " name="company" id="billing_company"/>
                                    </p>

                                    <p class="form-row form-row form-row-last validate-required validate-phone" id="billing_phone_field">
                                    <label for="billing_phone" class="">Phone <abbr class="required" title="required">*</abbr></label>
                                    <input type="tel" class="input-text " name="phone" id="billing_phone"/>
                                    </p>
                                    <div class="clear"></div>

                                    <p class="form-row form-row form-row-first address-field update_totals_on_change validate-required" id="billing_country_field">
                                        <label for="billing_country" class="">Country <abbr class="required" title="required">*</abbr></label>

                                        <select class="form-select" id="country_id" name="country_id">
                                            <option value="">- Please select -</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </p>
                                    <p class="form-row form-row form-row-last address-field update_totals_on_change validate-required" id="billing_country_field">
                                        <label for="billing_country" class="">City <abbr class="required" title="required">*</abbr></label>

                                        <select class="form-select" id="city_id" name="city_id">
                                            <option value="">- Please select -</option>
                                        </select>
                                    </p>
                                    <p class="form-row form-row form-row-wide address-field validate-required" id="billing_address_1_field">
                                        <label for="billing_address_1" class="">Address <abbr class="required" title="required">*</abbr></label>
                                        <input type="text" class="input-text " name="address" id="billing_address_1"/>
                                    </p>
                                    </div>
                                    <p class="form-row form-row notes" id="order_comments_field">
                                        <label for="order_comments" class="">Order Notes</label>
                                        <textarea name="order_note" class="input-text " id="order_comments" rows="2" cols="5"></textarea>
                                    </p>
                                </div>
                            </div>
                            <h3 id="order_review_heading">Your order</h3>
                            <div id="order_review" class="woocommerce-checkout-review-order">
                                @php
                                    $grandTotal = $subtotal - ($subtotal*(session('code_discount')/100));
                                @endphp

                                <table class="shop_table woocommerce-checkout-review-order-table">
                                    <tr class="cart-subtotal">
                                        <th>Subtotal</th>
                                        <td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">$</span>{{ $subtotal }}</span>
                                        </td>
                                        <input type="hidden" name="order_total" value="{{ $subtotal }}">
                                    </tr>
                                    <tr class="cart-subtotal">
                                        <th>Discount</th>
                                        <td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"></span>{{ session('code_discount') }}%</span>
                                        </td>
                                        <input type="hidden" name="order_discount" value="{{ session('code_discount') }}">
                                    </tr>
                                    <tr class="shipping">
                                        <th>Delivery Charge</th>
                                        <td data-title="Shipping">
                                            <ul class="wc_payment_methods payment_methods methods list-group" style="
                                            list-style: none;">
                                                <li class="wc_payment_method payment_method_cheque mb-2">
                                                    <input id="inside" type="radio" class="input-radio" name="delivery_charge" value="100"/>
                                                    <span class='grop-woo-radio-style'></span>
                                                    <!--custom change-->
                                                    <label for="inside">Inside Dhaka &nbsp; ($100)</label>
                                                </li>
                                                <li class="wc_payment_method payment_method_paypal mb-2">
                                                    <input id="outside" type="radio" class="input-radio" name="delivery_charge" value="200"/>
                                                    <!--grop add span for radio button style-->
                                                    <span class='grop-woo-radio-style'></span>
                                                    <!--custom change-->
                                                    <label for="outside">Outside Dhaka &nbsp; ($200)</label>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr class="order-total">
                                        <th>Total</th>
                                        <td><strong><span class="woocommerce-Price-amount amount">$<span class="woocommerce-Price-currencySymbol"  id="grandTotal">{{ $grandTotal }}</span></span></strong> </td>
                                    </tr>
                                </table>
                                <input type="hidden" id="checkout_charge" value="{{ $grandTotal }}">

                                <input type="hidden" id="main_cart" name="main_cartPrice" value="{{ $grandTotal }}">

                                <div id="payment" class="woocommerce-checkout-payment py-3 mt-5">
                                    <ul class="wc_payment_methods payment_methods methods">
                                    <li class="wc_payment_method payment_method_cheque mb-2">
                                        <input id="payment_method_cheque" type="radio" class="input-radio" name="payment_method" value="1" data-order_button_text="" />
                                        <!--grop add span for radio button style-->
                                        <span class='grop-woo-radio-style'></span>
                                        <!--custom change-->
                                        <label for="payment_method_cheque"> <span id="cash_on">Cash On Delivery</span></label>
                                    </li>
                                    <li class="wc_payment_method payment_method_paypal mb-2">
                                        <input id="payment_method_ssl" type="radio" class="input-radio" name="payment_method" value="2" />
                                        <!--grop add span for radio button style-->
                                        <span class='grop-woo-radio-style'></span>
                                        <!--custom change-->
                                        <label for="payment_method_ssl"> <span id="ssl_comz">SSL Commerz</span></label>
                                    </li>
                                    <li class="wc_payment_method payment_method_paypal">
                                        <input id="payment_method_stripe" type="radio" class="input-radio" name="payment_method" value="3" />
                                        <!--grop add span for radio button style-->
                                        <span class='grop-woo-radio-style'></span>
                                        <!--custom change-->
                                        <label for="payment_method_stripe"><span id="stripe">Stripe Payment</span></label>
                                    </li>
                                    @error('payment_method')
                                        <li class="wc_payment_method payment_method_paypal">
                                            <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                <strong>Warning!</strong> {{ $message }}
                                            </div>
                                        </li>
                                    @enderror
                                    </ul>
                                    <div class="form-row place-order">

                                    <input type="submit" class="button alt" name="woocommerce_checkout_place_order" value="Place order" />
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- checkout-section - end
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
        $('#country_id').change(function ()
        {
            var country_id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/checkout/getcity",
                data: {'country_id':country_id},
                dataType: "json",
                success: function (cityData) {
                    $('#city_id').html(cityData);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#country_id').select2();
            $('#city_id').select2();
        });
        $('#inside').click(function () {
            var charge = 100;
            var grandTotal = $('#checkout_charge').val();
            var total = parseInt(grandTotal)+parseInt(charge);
            $('#grandTotal').html(total);
            $('#main_cart').val(total);
        });

        $('#outside').click(function () {
            var charge = 200;
            var grandTotal = $('#checkout_charge').val();
            var total = parseInt(grandTotal)+parseInt(charge);
            $('#grandTotal').html(total);
            $('#main_cart').val(total);
        });
    </script>



@endsection
