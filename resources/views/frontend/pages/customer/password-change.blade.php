@extends('frontend.layouts.template')

@section('frontendBodyContent')

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
                <li><a href="index.html">Home</a></li>
                <li>Login/Register</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb_section - end
    ================================================== -->

    <!-- register_section - start
    ================================================== -->
    <section class="register_section section_space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <ul class="nav register_tabnav ul_li_center" role="tablist">
                        <li role="presentation">
                            <button class="active" data-bs-toggle="tab" data-bs-target="#signin_tab" type="button" role="tab" aria-controls="signin_tab" aria-selected="true">Change Password</button>
                        </li>
                    </ul>

                    <div class="register_wrap tab-content">
                        <div class="tab-pane fade show active" id="signin_tab" role="tabpanel">
                            <form action="{{ route('customer.password_store') }}" method="POST">
                                @csrf
                                <div class="form_item_wrap">
                                    <h3 class="input_title">Password*</h3>
                                    <div class="form_item">
                                        <label for="password_input2"><i class="fas fa-lock"></i></label>
                                        <input id="password_input2" type="password" name="password" placeholder="Password">
                                    </div>
                                </div>
 
                                <div class="form_item_wrap">
                                    <h3 class="input_title">Confirm Password*</h3>
                                    <div class="form_item">
                                        <label for="password_input3"><i class="fas fa-lock"></i></label>
                                        <input id="password_input3" type="password" name="password_confirmation" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form_item_wrap">
                                    <button type="submit" class="btn btn_primary">Submit</button>
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
@endsection
