<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared/title-meta', ['title' => $page_title])
    @yield('css')
    @include('layouts.shared/head-css')
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/favicon-ptpn.ico') }}">
    @vite(['resources/js/head.js'])
</head>

<body>
    <!-- Pre-loader -->
    {{-- <div id="preloader">
        <div id="status">
            <div class="bouncing-loader">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div> --}}
    <!-- End Preloader-->

    <div class="wrapper">

        @include('admin.layouts/topbar')
        @include('sweetalert::alert')
        @include('admin.layouts/left-sidebar')

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                @yield('content')
            </div>
            @include('layouts.shared/footer')
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>

    @include('layouts.shared/footer-script')
    @vite(['resources/js/app.js', 'resources/js/layout.js'])
    @yield('script')

</body>

</html>
