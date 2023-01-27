@extends('frontend.layouts.template')

@section('frontendBodyContent')
    <main>
        <!-- sidebar cart - start
        ================================================== -->
        <div class="sidebar-menu-wrapper">
            <div class="cart_sidebar">
                <button type="button" class="close_btn"><i class="fal fa-times"></i></button>
                <ul class="cart_items_list ul_li_block mb_30 clearfix">
                    <li>
                        <div class="item_image">
                            <img src="assets/images/cart/cart_img_1.jpg" alt="image_not_found">
                        </div>
                        <div class="item_content">
                            <h4 class="item_title">Yellow Blouse</h4>
                            <span class="item_price">$30.00</span>
                        </div>
                        <button type="button" class="remove_btn"><i class="fal fa-trash-alt"></i></button>
                    </li>
                    <li>
                        <div class="item_image">
                            <img src="assets/images/cart/cart_img_2.jpg" alt="image_not_found">
                        </div>
                        <div class="item_content">
                            <h4 class="item_title">Yellow Blouse</h4>
                            <span class="item_price">$30.00</span>
                        </div>
                        <button type="button" class="remove_btn"><i class="fal fa-trash-alt"></i></button>
                    </li>
                    <li>
                        <div class="item_image">
                            <img src="assets/images/cart/cart_img_3.jpg" alt="image_not_found">
                        </div>
                        <div class="item_content">
                            <h4 class="item_title">Yellow Blouse</h4>
                            <span class="item_price">$30.00</span>
                        </div>
                        <button type="button" class="remove_btn"><i class="fal fa-trash-alt"></i></button>
                    </li>
                </ul>

                <ul class="total_price ul_li_block mb_30 clearfix">
                    <li>
                        <span>Subtotal:</span>
                        <span>$90</span>
                    </li>
                    <li>
                        <span>Vat 5%:</span>
                        <span>$4.5</span>
                    </li>
                    <li>
                        <span>Discount 20%:</span>
                        <span>- $18.9</span>
                    </li>
                    <li>
                        <span>Total:</span>
                        <span>$75.6</span>
                    </li>
                </ul>

                <ul class="btns_group ul_li_block clearfix">
                    <li><a class="btn btn_primary" href="cart.html">View Cart</a></li>
                    <li><a class="btn btn_secondary" href="checkout.html">Checkout</a></li>
                </ul>
            </div>

            <div class="cart_overlay"></div>
        </div>
        <!-- sidebar cart - end
        ================================================== -->

        <!-- breadcrumb_section - start
        ================================================== -->
        <div class="breadcrumb_section">
            <div class="container">
                <ul class="breadcrumb_nav ul_li">
                    <li><a href="index.html">Home</a></li>
                    <li>Wishlist</li>
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
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>PRODUCT</th>
                                <th class="text-center">PRICE</th>
                                <th class="text-center">STOCK STATUS</th>
                                <th class="text-center">ADD TO CART</th>
                                <th class="text-center">REMOVE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="cart_product">
                                        <img src="assets/images/compare/compare_img_1.jpg" alt="image_not_found" />
                                        <h3>Your Product Title Here</h3>
                                    </div>
                                </td>
                                <td class="text-center"><span class="price_text">$10.50</span></td>
                                <td class="text-center"><span class="price_text text-success">In Stock</span></td>
                                <td class="text-center">
                                    <a href="#!" class="btn btn_primary">Add To Cart</a>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="remove_btn"><i class="fal fa-trash-alt"></i></button>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="cart_product">
                                        <img src="assets/images/compare/compare_img_2.jpg" alt="image_not_found" />
                                        <h3>Your Product Title Here</h3>
                                    </div>
                                </td>
                                <td class="text-center"><span class="price_text">$10.50</span></td>
                                <td class="text-center"><span class="price_text text-danger">Out Stock</span></td>
                                <td class="text-center">
                                    <a href="#!" class="btn btn_primary">Add To Cart</a>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="remove_btn"><i class="fal fa-trash-alt"></i></button>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="cart_product">
                                        <img src="assets/images/compare/compare_img_3.jpg" alt="image_not_found" />
                                        <h3>Your Product Title Here</h3>
                                    </div>
                                </td>
                                <td class="text-center"><span class="price_text">$10.50</span></td>
                                <td class="text-center"><span class="price_text text-success">In Stock</span></td>
                                <td class="text-center">
                                    <a href="#!" class="btn btn_primary">Add To Cart</a>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="remove_btn"><i class="fal fa-trash-alt"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
