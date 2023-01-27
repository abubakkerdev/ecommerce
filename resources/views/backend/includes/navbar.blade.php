<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li>
                <a href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            {{-- <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-layer-1"></i>
                    <span class="nav-text">Pages</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="./page-register.html">Register</a></li>
                    <li><a href="./page-login.html">Login</a></li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Error</a>
                        <ul aria-expanded="false">
                            <li><a href="./page-error-400.html">Error 400</a></li>
                            <li><a href="./page-error-403.html">Error 403</a></li>
                            <li><a href="./page-error-404.html">Error 404</a></li>
                            <li><a href="./page-error-500.html">Error 500</a></li>
                            <li><a href="./page-error-503.html">Error 503</a></li>
                        </ul>
                    </li>
                    <li><a href="./page-lock-screen.html">Lock Screen</a></li>
                </ul>
            </li> --}}


            <!-- Category Menu Start -->
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-layer-1"></i>
                    <span class="nav-text">Category</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('category') }}">Manage Category</a></li>
                </ul>
            </li>
            <!-- Category Menu End -->

            <!-- Subcategory Menu Start -->
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-layer-1"></i>
                    <span class="nav-text">Subcategory</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('subcategory.index') }}">Manage Subcategory</a></li>
                </ul>
            </li>
            <!-- Subcategory Menu End -->

            <!-- Products Menu Start -->
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-layer-1"></i>
                    <span class="nav-text">Products</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('product.manage') }}">Manage Product</a></li>
                    <li><a href="{{ route('product.create') }}">Create Product</a></li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Color</a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('inventory.color') }}">Manage Color</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Size</a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('inventory.size') }}">Manage Size</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <!-- Products Menu End -->

            <!-- Inventory Menu Start -->
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-layer-1"></i>
                    <span class="nav-text">Inventory</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('inventory.all') }}">Manage Inventory</a></li>
                    <li><a href="{{ route('inventory.create') }}">Create Inventory</a></li>
                </ul>
            </li>
            <!-- Inventory Menu End -->

            <!-- Coupon Menu Start -->
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-layer-1"></i>
                    <span class="nav-text">Coupon</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('coupon.index') }}">Manage Coupon</a></li>
                </ul>
            </li>
            <!-- Coupon Menu End -->


            <!-- Users Menu Start -->
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-layer-1"></i>
                    <span class="nav-text">Users</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('user.manage') }}">Manage User</a></li>
                </ul>
            </li>
            <!-- Users Menu End -->
        </ul>

        <div class="copyright">
            <p><strong>Gymove Fitness Admin Dashboard</strong> © 2020 All Rights Reserved</p>
            <p>Made with <span class="heart"></span> by Cit Student</p>
        </div>
    </div>
</div>
