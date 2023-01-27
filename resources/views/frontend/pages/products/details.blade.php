@extends('frontend.layouts.template')

@section('frontendBodyContent')

    <main>
        <!-- sidebar cart - start
        ================================================== -->
        @include('frontend.includes.cart')
        <!-- sidebar cart - end
        ================================================== -->

        <!-- product quick view modal - start
        ================================================== -->
        @foreach ($related_products as $rel_product)
            <div class="modal fade" id="view_popup{{ $rel_product->id }}" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalToggleLabel2">Product Quick View</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="product_details">
                                <div class="container">
                                    <div class="row">
                                        <div class="col col-lg-6">
                                            <div class="product_details_image p-0">
                                                <img src="{{ asset('backend/uploads/product/preview/'.$rel_product->product_preview) }}" alt>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="product_details_content">
                                                <h2 class="item_title">{{ $rel_product->product_name }}</h2>
                                                <p>
                                                    {{ $rel_product->product_desc }}
                                                </p>
                                                <div class="item_review">
                                                    <ul class="rating_star ul_li">
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                        <li><i class="fas fa-star"></i></li>
                                                    </ul>
                                                    <span class="review_value">3 Rating(s)</span>
                                                </div>
                                                <div class="item_price">
                                                    @if (!empty($rel_product->discount))
                                                        <span>${{ $rel_product->after_discount }}</span>
                                                        <del>${{ $rel_product->product_price }}</del>
                                                    @else
                                                        <span>${{ $rel_product->product_price }}</span>
                                                    @endif
                                                </div>
                                                <hr>
                                                <div class="item_attribute">
                                                    <h3 class="title_text">Options <span class="underline"></span></h3>
                                                    <form action="#">
                                                        <div class="row">
                                                            <div class="col col-md-6">
                                                                <div class="select_option clearfix">
                                                                    <h4 class="input_title">Size *</h4>
                                                                    <select class="home_viewsize">
                                                                        <option data-display="- Please select -">Choose A Option</option>
                                                                        @foreach ($sizes as $size)
                                                                            <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col col-md-6">
                                                                <div class="select_option clearfix">
                                                                    <h4 class="input_title">Color *</h4>
                                                                    <select class="home_viewsize">
                                                                        <option data-display="- Please select -">Choose A Option</option>
                                                                        @foreach ($colors as $color)
                                                                            <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="quantity_wrap">
                                                    <form action="#">
                                                        <div class="quantity_input">
                                                            <button type="button" class="input_number_decrement">
                                                                <i class="fal fa-minus"></i>
                                                            </button>
                                                            <input class="input_number" type="text" value="1">
                                                            <button type="button" class="input_number_increment">
                                                                <i class="fal fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                    @if (!empty($rel_product->discount))
                                                        <div class="total_price">Total: $<span>{{ $rel_product->after_discount }}</span></div>
                                                    @else
                                                        <div class="total_price">Total: $<span>{{ $rel_product->product_price }}</span></div>
                                                    @endif
                                                </div>

                                                <ul class="default_btns_group ul_li">
                                                    <li><a class="addtocart_btn" href="#!">Add To Cart</a></li>
                                                    <li><a href="#!"><i class="far fa-compress-alt"></i></a></li>
                                                    <li><a href="#!"><i class="fas fa-heart"></i></a></li>
                                                </ul>

                                                <ul class="default_share_links ul_li">
                                                    <li>
                                                        <a class="facebook" href="#!">
                                                            <span><i class="fab fa-facebook-square"></i> Like</span>
                                                            <small>10K</small>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="twitter" href="#!">
                                                            <span><i class="fab fa-twitter-square"></i> Tweet</span>
                                                            <small>15K</small>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="google" href="#!">
                                                            <span><i class="fab fa-google-plus-square"></i> Google+</span>
                                                            <small>20K</small>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="share" href="#!">
                                                            <span><i class="fas fa-plus-square"></i> Share</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- product quick view modal - end
        ================================================== -->

        <!-- breadcrumb_section - start
        ================================================== -->
        <div class="breadcrumb_section">
            <div class="container">
                <ul class="breadcrumb_nav ul_li">
                    <li><a href="{{ route('home.page') }}">Home</a></li>
                    <li>Product Details</li>
                </ul>
            </div>
        </div>
        <!-- breadcrumb_section - end
        ================================================== -->

        <!-- product_details - start
        ================================================== -->
        <section class="product_details section_space pb-0">
            <div class="container">
                <div class="row">
                    <div class="col col-lg-6">
                        <div class="product_details_image">
                            <div class="details_image_carousel">
                                @foreach ( $product->product_thumbnail as $product_img)
                                    <div class="slider_item">
                                        <img src="{{ asset('backend/uploads/product/thumbnail/'.$product_img->product_thumbnail) }}" alt="image_not_found">
                                    </div>
                                @endforeach
                            </div>

                            <div class="details_image_carousel_nav">
                                @foreach ( $product->product_thumbnail as $product_img)
                                    <div class="slider_item">
                                        <img src="{{ asset('backend/uploads/product/thumbnail/'.$product_img->product_thumbnail) }}" alt="image_not_found">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="product_details_content">
                            <h2 class="item_title">{{ $product->product_name }}</h2>
                            <p>{{ $product->short_desc }}</p>
                            <div class="item_review">
                                <ul class="rating_star ul_li">
                                    <li><i class="fas fa-star"></i>></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star"></i></li>
                                    <li><i class="fas fa-star-half-alt"></i></li>
                                </ul>
                                <span class="review_value">3 Rating(s)</span>
                            </div>

                            <div class="item_price">
                                @if (!empty($product->discount))
                                    <span>$<span id="after_discount">{{ $product->after_discount }}</span></span>
                                    <del>$<span>{{ $product->product_price }}</span></del>
                                @else
                                    <span>$<span id="product_price">{{ $product->product_price }}</span></span>
                                @endif
                            </div>
                            <hr>

                            <div class="item_attribute">
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col col-md-6">
                                            <div class="select_option clearfix">
                                                <h4 class="input_title">Color *</h4>
                                                <select class="form-select" id="color_id" name="product_colorid">
                                                    <option value="">- Please select -</option>
                                                    <option value="">Choose A Option</option>

                                                    @foreach ($available_colors as $colors)
                                                        <option value="{{ $colors->rel_to_color->id }}">{{ $colors->rel_to_color->color_name }}</option>
                                                @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col col-md-6">
                                            @if ($exist_size)
                                                <input type="hidden" name="product_sizeid" value="{{ App\Models\Backend\Inventory::where('product_id', $product->id)->first()->size_id }}">
                                            @else
                                                <div class="select_option clearfix">
                                                    <h4 class="input_title">Size *</h4>
                                                    <select class="form-select" name="product_sizeid" id="size_id">
                                                        <option value="">- Please select -</option>
                                                        <option value="">Choose A Option</option>
                                                    </select>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="quantity_wrap">
                                    <div class="quantity_input">
                                        <button type="button" class="input_number_decrement">
                                            <i class="fal fa-minus"></i>
                                        </button>

                                        <input class="input_number" name="product_quantity" type="number" value="1">

                                        <button type="button" class="input_number_increment">
                                            <i class="fal fa-plus"></i>
                                        </button>
                                    </div>
                                    @if (!empty($product->discount))
                                        <div class="total_price">Total: $<span id="total">{{ $product->after_discount }}</span></div>
                                    @else
                                        <div class="total_price">Total: $<span id="total">{{ $product->product_price }}</span>
                                        </div>
                                    @endif

                                </div>

                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <ul class="default_btns_group ul_li">

                                    @auth('customer')
                                        <li><button type="submit" class="btn btn_primary addtocart_btn">Add To Cart</button></li>
                                    @else
                                        <li><a class="btn btn_primary addtocart_btn" href="{{ route('customer.register') }}">Add To Cart</a></li>
                                    @endauth
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="details_information_tab">
                    <ul class="tabs_nav nav ul_li" role=tablist>
                        <li>
                            <button class="active" data-bs-toggle="tab" data-bs-target="#description_tab" type="button" role="tab" aria-controls="description_tab" aria-selected="true">
                            Description
                            </button>
                        </li>
                        <li>
                            <button data-bs-toggle="tab" data-bs-target="#additional_information_tab" type="button" role="tab" aria-controls="additional_information_tab" aria-selected="false">
                            Additional information
                            </button>
                        </li>
                        <li>
                            <button data-bs-toggle="tab" data-bs-target="#reviews_tab" type="button" role="tab" aria-controls="reviews_tab" aria-selected="false">
                            Reviews(2)
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="description_tab" role="tabpanel">
                            <p>{{ $product->product_desc }}</p>
                        </div>

                        <div class="tab-pane fade" id="additional_information_tab" role="tabpanel">
                            <p>
                            Return into stiff sections the bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked what's happened to me he thought It wasn't a dream. His room, a proper human room although a little too small
                            </p>

                            <div class="additional_info_list">
                                <h4 class="info_title">Additional Info</h4>
                                <ul class="ul_li_block">
                                    <li>No Side Effects</li>
                                    <li>Made in USA</li>
                                </ul>
                            </div>

                            <div class="additional_info_list">
                                <h4 class="info_title">Product Features Info</h4>
                                <ul class="ul_li_block">
                                    <li>Compatible for indoor and outdoor use</li>
                                    <li>Wide polypropylene shell seat for unrivalled comfort</li>
                                    <li>Rust-resistant frame</li>
                                    <li>Durable UV and weather-resistant construction</li>
                                    <li>Shell seat features water draining recess</li>
                                    <li>Shell and base are stackable for transport</li>
                                    <li>Choice of monochrome finishes and colourways</li>
                                    <li>Designed by Nagi</li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="reviews_tab" role="tabpanel">
                            <div class="average_area">
                                <div class="row align-items-center">
                                    <div class="col-md-12 order-last">
                                        <div class="average_rating_text">
                                            <ul class="rating_star ul_li_center">
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                            </ul>
                                            <p class="mb-0">
                                            Average Star Rating: <span>4 out of 5</span> (2 vote)
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="customer_reviews">
                                <h4 class="reviews_tab_title">2 reviews for this product</h4>
                                <div class="customer_review_item clearfix">
                                    <div class="customer_image">
                                        <img src="assets/images/team/team_1.jpg" alt="image_not_found">
                                    </div>
                                    <div class="customer_content">
                                        <div class="customer_info">
                                            <ul class="rating_star ul_li">
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star-half-alt"></i></li>
                                            </ul>
                                            <h4 class="customer_name">Aonathor troet</h4>
                                            <span class="comment_date">JUNE 2, 2021</span>
                                        </div>
                                        <p class="mb-0">Nice Product, I got one in black. Goes with anything!</p>
                                    </div>
                                </div>

                                <div class="customer_review_item clearfix">
                                    <div class="customer_image">
                                        <img src="assets/images/team/team_2.jpg" alt="image_not_found">
                                    </div>
                                    <div class="customer_content">
                                        <div class="customer_info">
                                            <ul class="rating_star ul_li">
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star"></i></li>
                                                <li><i class="fas fa-star-half-alt"></i></li>
                                            </ul>
                                            <h4 class="customer_name">Danial obrain</h4>
                                            <span class="comment_date">JUNE 2, 2021</span>
                                        </div>
                                        <p class="mb-0">
                                        Great product quality, Great Design and Great Service.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="customer_review_form">
                                <h4 class="reviews_tab_title">Add a review</h4>
                                <form action="#">
                                    <div class="form_item">
                                        <input type="text" name="name" placeholder="Your name*">
                                    </div>
                                    <div class="form_item">
                                        <input type="email" name="email" placeholder="Your Email*">
                                    </div>
                                    <div class="your_ratings">
                                        <h5>Your Ratings:</h5>
                                        <button type="button"><i class="fal fa-star"></i></button>
                                        <button type="button"><i class="fal fa-star"></i></button>
                                        <button type="button"><i class="fal fa-star"></i></button>
                                        <button type="button"><i class="fal fa-star"></i></button>
                                        <button type="button"><i class="fal fa-star"></i></button>
                                    </div>
                                    <div class="form_item">
                                        <textarea name="comment" placeholder="Your Review*"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn_primary">Submit Now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- product_details - end
        ================================================== -->

        <!-- related_products_section - start
        ================================================== -->
        <section class="related_products_section section_space">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="best-selling-products related-product-area">
                            <div class="sec-title-link">
                                <h3>Related products</h3>
                                <div class="view-all"><a href="#">View all<i class="fal fa-long-arrow-right"></i></a></div>
                            </div>
                            <div class="product-area row clearfix">

                                @foreach ($related_products as $related_product)
                                    <div class="grid col-lg-3">
                                        <div class="product-pic">
                                            <img src="{{ asset('backend/uploads/product/preview/'. $related_product->product_preview) }}" alt>
                                            @if (!empty($related_product->discount))
                                                <span class="theme-badge-2">{{ $related_product->discount }}% off</span>
                                            @endif

                                            <div class="actions">
                                                <ul>
                                                    <li>
                                                        <a href="#"><svg role="img" xmlns="http://www.w3.org/2000/svg" width="48px" height="48px" viewBox="0 0 24 24" stroke="#2329D6" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#2329D6"> <title>Favourite</title> <path d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z"/> </svg></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><svg role="img" xmlns="http://www.w3.org/2000/svg" width="48px" height="48px" viewBox="0 0 24 24" stroke="#2329D6" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#2329D6"> <title>Shuffle</title> <path d="M21 16.0399H17.7707C15.8164 16.0399 13.9845 14.9697 12.8611 13.1716L10.7973 9.86831C9.67384 8.07022 7.84196 7 5.88762 7L3 7"/> <path d="M21 7H17.7707C15.8164 7 13.9845 8.18388 12.8611 10.1729L10.7973 13.8271C9.67384 15.8161 7.84196 17 5.88762 17L3 17"/> <path d="M19 4L22 7L19 10"/> <path d="M19 13L22 16L19 19"/> </svg></a>
                                                    </li>
                                                    <li>
                                                        <a class="quickview_btn" data-bs-toggle="modal" href="#view_popup{{ $related_product->id }}" role="button" tabindex="0"><svg width="48px" height="48px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"  stroke="#2329D6" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#2329D6"> <title>Visible (eye)</title> <path d="M22 12C22 12 19 18 12 18C5 18 2 12 2 12C2 12 5 6 12 6C19 6 22 12 22 12Z"/> <circle cx="12" cy="12" r="3"/> </svg></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="details">
                                            <h4><a href="{{ route('product.index',$related_product->id) }}">{{ $related_product->product_name }}</a></h4>
                                            <p><a href="{{ route('product.index',$related_product->id) }}">{{ $related_product->short_desc }}</a></p>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </div>
                                            <span class="price">
                                                @if (!empty($related_product->discount))
                                                    <ins>
                                                        <span class="woocommerce-Price-amount amount">
                                                            <bdi>
                                                                <span class="woocommerce-Price-currencySymbol">$</span>{{ $related_product->after_discount }}
                                                            </bdi>
                                                        </span>
                                                    </ins>
                                                    <del aria-hidden="true">
                                                        <span class="woocommerce-Price-amount amount">
                                                            <bdi>
                                                                <span class="woocommerce-Price-currencySymbol">$</span>{{ $related_product->product_price }}
                                                            </bdi>
                                                        </span>
                                                    </del>
                                                @else
                                                    <ins>
                                                        <span class="woocommerce-Price-amount amount">
                                                            <bdi>
                                                                <span class="woocommerce-Price-currencySymbol">$</span>{{ $related_product->product_price }}
                                                            </bdi>
                                                        </span>
                                                    </ins>
                                                @endif
                                            </span>
                                            <div class="add-cart-area">
                                                <button class="add-to-cart">Add to cart</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- related_products_section - end
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
        $('.input_number_increment').click(function () {
            var item            = $('.input_number').val();
            var product_price   = $('#product_price').html();
            var discount        = $('#after_discount').html();

            $('.input_number_decrement').attr('disabled', false);
            $('.input_number').attr('readonly', false);

            if (discount)
            {
                var total = discount*item;
                $('#total').html(total);
            }
            else {
                var intotal = product_price*item;
                $('#total').html(intotal);
            }
        });

        $('.input_number_decrement').click(function () {
            var item            = $('.input_number').val();
            var product_price   = $('#product_price').html();
            var discount        = $('#after_discount').html();

            if (item == 0)
            {
                $('.input_number').val(1);
                $('.input_number_decrement').attr('disabled', true);
                $('.input_number').attr('readonly', true);

                if (discount)
                {
                    $('#total').html(discount);
                }
                else {
                    $('#total').html(product_price);
                }
            }
            else {
                if (discount)
                {
                    var total = discount*item;
                    $('#total').html(total);
                }
                else {
                    var intotal = product_price*item;
                    $('#total').html(intotal);
                }
            }
        });
    </script>
    <script>
        $('#color_id').change(function ()
        {
            var color_id = $(this).val();
            var product_id = "{{ $product->id }}";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/product/getsize",
                data: {'color_id':color_id, 'product_id':product_id},
                dataType: "json",
                success: function (catData) {
                    $('#size_id').html(catData);
                }
            });
        });
    </script>

    @if (session()->has('cart_store'))
        <script>
            $.toast({
                heading: 'Success',
                text: '{{ session()->get("cart_store") }}',
                position: 'top-right',
                hideAfter: 2500,
                showHideTransition: 'slide'
            });
        </script>
    @endif
@endsection
