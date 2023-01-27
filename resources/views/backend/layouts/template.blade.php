<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Header Meta -->
    @include('backend.includes.header')

    <!-- Header Css -->
    @include('backend.includes.css')
</head>
<body>
    <!--*******************
        Preloader start
    ********************-->
    @include('backend.includes.loader')
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
		<!--**********************************
            Header Topbar start
        ***********************************-->
        @include('backend.includes.topbar')
        <!--**********************************
            Header Topbar end
        ***********************************-->

        <!--**********************************
            Left Side-Menu start
        ***********************************-->
        @include('backend.includes.navbar')
        <!--**********************************
            Left Side-Menu end
        ***********************************-->

		<!--**********************************
            Content body start
        ***********************************-->
        @yield('dashboardBodyContent')
        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
        @include('backend.includes.footer')
        <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Footer Scripts start
    ***********************************-->
    @include('backend.includes.script')
    <!--**********************************
        Footer Scripts end
    ***********************************-->

    <!--**********************************
        Footer Alert Scripts start
    ***********************************-->
    @yield('alertScripts')
    <!--**********************************
        Footer Alert Scripts end
    ***********************************-->
</body>
</html>
