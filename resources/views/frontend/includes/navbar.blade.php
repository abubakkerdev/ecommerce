<header class="header_section {{ (Route::currentRouteName() == 'home.page') ? 'header-style-no-collapse' : 'header-style-3' }}">
    <div class="header_top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col col-md-6">

                    @if (Route::currentRouteName() == 'checkout.confirm')

                    @else

                        {{ Session::forget('trans_one') }}
                        {{ Session::forget('trans_two') }}
                        {{ Session::forget('trans_three') }}
                    @endif


                    <ul class="header_select_options ul_li">
                        <li>
                            <div class="select_option">
                                <div class="flug_wrap">
                                    <img src="{{ asset('frontend/images/flug/flug_uk.png') }}" alt="image_not_found">
                                </div>
                                <select id="home_language">
                                    <option data-display="Select Option">Select Your Language</option>
                                    <option value="1" selected>English</option>
                                    <option value="2">Bangla</option>
                                    <option value="3" disabled>Arabic</option>
                                    <option value="4">Hebrew</option>
                                </select>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col col-md-6">
                    <p class="header_hotline">Call us toll free: <strong>+1888 234 5678</strong></p>
                </div>
            </div>
        </div>
    </div>

    <div class="header_middle">
        <div class="container">
            <div class="row align-items-center">
                <div class="col col-lg-3 col-md-3 col-sm-12">
                    <div class="brand_logo">
                        <a class="brand_link" href="{{ route('home.page') }}">
                            <img src="{{ asset('frontend/images/logo/logo_1x.png') }}" srcset="assets/images/logo/logo_2x.png 2x" alt>
                        </a>
                    </div>
                </div>
                <div class="col col-lg-6 col-md-6 col-sm-12">
                    <form action="#">
                        <div class="advance_serach">
                            <div class="select_option mb-0 clearfix">
                                <select id="home_category">
                                    <option data-display="All Categories">Select A Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->cat_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form_item">
                                <input type="search" name="search" placeholder="Search Prudcts...">
                                <button type="submit" class="search_btn"><i class="far fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col col-lg-3 col-md-3 col-sm-12">
                    <button class="mobile_menu_btn2 navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_menu_dropdown" aria-controls="main_menu_dropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fal fa-bars"></i>
                    </button>
                    <button type="button" class="cart_btn">
                       <ul class="header_icons_group ul_li_right">
                            <li>
                                <a href="wishlist.html">
                                    <svg role="img" xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24" stroke="#051d43" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#2329D6"> <title>Favourite</title> <path d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z"/> </svg>
                                    <span class="wishlist_counter">3</span>
                                </a>
                            </li>
                            <li>
                                <span class="cart_icon">
                                    <i class="icon icon-ShoppingCart"></i>
                                    <small class="cart_counter">{{ App\Models\Backend\Cart::where('customer_id',Auth::guard('customer')->id())->count(); }}</small>
                                </span>
                            </li>
                       </ul>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="header_bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col col-md-3">
                    <div class="allcategories_dropdown">
                        <button class="allcategories_btn" type="button" data-bs-toggle="collapse" data-bs-target="#allcategories_collapse" aria-expanded="false" aria-controls="allcategories_collapse">
                            <svg role="img" xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24" aria-labelledby="statsIconTitle" stroke="#000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none" color="#000"> <title id="statsIconTitle">Stats</title> <path d="M6 7L15 7M6 12L18 12M6 17L12 17"/> </svg>
                            Browse categories
                        </button>
                        <div class="allcategories_collapse {{ (Route::currentRouteName() == 'home.page') ? '' : 'collapse' }}" id="allcategories_collapse">
                            <div class="card card-body">
                                <ul class="allcategories_list ul_li_block">
                                    @foreach ($categories as $category)
                                        <li>
                                            <a href="">
                                                <i class="icon icon-DesktopMonitor"></i> {{ $category->cat_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col col-md-6">
                    <nav class="main_menu navbar navbar-expand-lg">
                        <div class="main_menu_inner collapse navbar-collapse" id="main_menu_dropdown">
                            <button type="button" class="offcanvas_close">
                                <i class="fal fa-times"></i>
                            </button>
                            <ul class="main_menu_list ul_li">
                                <li><a class="nav-link" href="#">Home</a></li>
                                <li><a class="nav-link" href="#">About us</a></li>
                                <li><a class="nav-link" href="#">Shop</a></li>
                                <li><a class="nav-link" href="#">Contact Us</a></li>
                            </ul>
                        </div>
                    </nav>
                    <div class="offcanvas_overlay"></div>
                </div>

                <div class="col col-md-3">
                    <ul class="header_icons_group ul_li_right">
                         <li>
                            @auth('customer')
                                <div class="dropdown">
                                    <button class="btn text-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ Auth::guard('customer')->user()->name }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('customer.profile') }}">Profile</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('customer.logout') }}">Logout</a>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <a href="{{ route('customer.register') }}">Login</a>
                            @endauth
                        </li>

                        <li>
                            <a href="account.html">
                                <svg role="img" xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" viewBox="0 0 24 24" stroke="#051d43" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#2329D6"> <title id="personIconTitle">Person</title> <path d="M4,20 C4,17 8,17 10,15 C11,14 8,14 8,9 C8,5.667 9.333,4 12,4 C14.667,4 16,5.667 16,9 C16,14 13,14 14,15 C16,17 20,17 20,20"/> </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
