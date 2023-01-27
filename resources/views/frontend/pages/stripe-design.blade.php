@extends('frontend.layouts.template')


@section('frontendBodyContent')
    <main>
        <!-- sidebar cart - start
        ================================================== -->
        @include('frontend.includes.cart')
        <!-- sidebar cart - end
        ================================================== -->





        <!-- register_section - start
        ================================================== -->
        <section class="register_section section_space">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">

                        <ul class="nav register_tabnav ul_li_center" role="tablist">
                            <li role="presentation">
                                <button data-bs-toggle="tab" data-bs-target="#signup_tab" type="button" role="tab" aria-controls="signup_tab" aria-selected="false">Stripe Payment</button>
                            </li>
                        </ul>

                        <div class="register_wrap tab-content">
                            <div class="tab-pane fade show active" id="signup_tab" role="tabpanel">
                                <form action="#">
                                    <div class="form_item_wrap">
                                        <h3 class="input_title">Name on Card</h3>
                                        <div class="form_item">
                                            <label for="username_input2"><i class="fas fa-user"></i></label>
                                            <input id="username_input2" type="text" name="username" placeholder="User Name">
                                        </div>
                                    </div>

                                    <div class="form_item_wrap">
                                        <h3 class="input_title">Card Number</h3>
                                        <div class="form_item">
                                            <label for="password_input2"><i class="fas fa-lock"></i></label>
                                            <input id="password_input2" type="password" name="password" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form_item_wrap">
                                        <h3 class="input_title">CVC</h3>
                                        <div class="form_item">
                                            <label for="password_input2"><i class="fas fa-lock"></i></label>
                                            <input id="password_input2" type="password" name="password" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form_item_wrap">
                                        <h3 class="input_title">Expiration Month</h3>
                                        <div class="form_item">
                                            <label for="password_input2"><i class="fas fa-lock"></i></label>
                                            <input id="password_input2" type="password" name="password" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form_item_wrap">
                                        <h3 class="input_title">Expiration Year</h3>
                                        <div class="form_item">
                                            <label for="password_input2"><i class="fas fa-lock"></i></label>
                                            <input id="password_input2" type="password" name="password" placeholder="Password">
                                        </div>
                                    </div>

                                    <div class="form_item_wrap">
                                        <button type="submit" class="btn btn_secondary">Pay Now ($60)</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- register_section - end
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
