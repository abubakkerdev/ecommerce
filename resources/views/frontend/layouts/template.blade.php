<!doctype html>
<html lang="en">
<head>
    <!-- Header Meta -->
    @include('frontend.includes.header')

    <!-- Header Css -->
    @include('frontend.includes.css')
</head>

<body>

    <!-- body_wrap - start --> 
    <div class="body_wrap">

        <!-- backtotop & preloader - start -->
        @include('frontend.includes.loader')
        <!-- backtotop & preloader - end -->

        <!-- header_menu_section - start
        ================================================== -->
        @include('frontend.includes.navbar')
        <!-- header_menu_section - end
        ================================================== -->

        <!-- main body - start
        ================================================== -->
        @yield('frontendBodyContent')
        <!-- main body - end
        ================================================== -->

        <!-- footer_section - start
        ================================================== -->
        @include('frontend.includes.footer')
        <!-- footer_section - end
        ================================================== -->

    </div>
    <!-- body_wrap - end -->

    <!-- Footer Script -->
    @include('frontend.includes.script')
    @yield('footerScript')

</body>
</html>
