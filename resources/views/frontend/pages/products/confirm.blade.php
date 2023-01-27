@extends('frontend.layouts.template')

@section('frontendBodyContent')

    <main>
        <!-- sidebar cart - start
        ================================================== -->
        @include('frontend.includes.cart')
        <!-- sidebar cart - end
        ================================================== -->


        <!-- account_section - start
        ================================================== -->
        <section class="account_section section_space">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 m-auto">
                        <h2>Transaction is successfully Completed</h2>
                    </div>
                </div>
            </div>
        </div>
        </section>
        <!-- account_section - end
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
