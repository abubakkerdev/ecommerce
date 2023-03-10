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
                <li>My Account</li>
            </ul>
        </div>
    </div>
    <!-- breadcrumb_section - end
    ================================================== -->


    <!-- account_section - start
    ================================================== -->
    <section class="account_section section_space">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 account_menu">
                    <div class="nav account_menu_list flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link text-start active w-100" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Account Dashboard </button>
                        <button class="nav-link text-start w-100" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Acount</button>
                        <button class="nav-link text-start w-100" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">My Orders</button>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="tab-content bg-light p-3" id="v-pills-tabContent">
                        <div class="tab-pane fade show active text-center" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <h5>Welcome to Account</h5>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <h5 class="text-center pb-3">Account Details</h5>
                            <form action="{{ route('customer.profile_update') }}" class="row g-3 p-2" method="POST">
                                @csrf
                                <div class="col-md-6">
                                    <label for="inputnamel4" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="inputnamel4" name="name" value="{{ Auth::guard('customer')->user()->name }}">
                                    @error('name')
                                        <div class="alert alert-warning mt-3" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="inputEmail4" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="inputEmail4" readonly value="{{ Auth::guard('customer')->user()->email }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputPassword4" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="inputPassword4">

                                    @error('password')
                                        <div class="alert alert-warning mt-3" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="inputPassword45" class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" id="inputPassword45">
                                </div>

                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary active">Update</button>
                                </div>
                                </form>
                            </div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                            <h5 class="text-center pb-3">Your Orders</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>SL</th>
                                    <th>Order No</th>
                                    <th>Sub Total</th>
                                    <th>Discount</th>
                                    <th>Delivery Charge</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($order as $key => $order_info)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>#{{ $order_info->id }}</td>
                                        <td>
                                            {{ ($order_info->total - $order_info->delivery_charge)+($order_info->total*$order_info->discount)/100 }}</td>
                                        <td>{{ $order_info->discount }}%</td>
                                        <td>{{ $order_info->delivery_charge }}</td>
                                        <td>{{ $order_info->total }}</td>
                                        <td>
                                            <a href="{{ route('invoice', $order_info->id) }}" class="btn btn-primary">Download Invoice</a>

                                            <a href="{{ route('customer.mail', $order_info->id) }}" class="btn btn-primary">Send Mail</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                    </div>
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
@endsection

@section('footerScript')
    @if (session()->has('profile-update'))
        <script>
            $.toast({
                heading: 'Update successful',
                text: '{{ session()->get("profile-update") }}',
                icon: 'info',
                position: 'top-right',
                hideAfter: 2500,
                showHideTransition: 'slide'
            });
        </script>
    @endif
@endsection
