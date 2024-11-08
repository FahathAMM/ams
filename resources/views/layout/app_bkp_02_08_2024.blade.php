<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar="light" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    {{-- <title>Dashboard | Velzon - Admin & Dashboard Template</title> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('/assets/images/favicon.ico') }}" />

    <!-- jsvectormap css -->
    {{-- @vite(['resources/assets/libs/jsvectormap/css/jsvectormap.min.css']) --}}

    <!--Swiper slider css-->
    {{-- @vite(['resources/assets/libs/swiper/swiper-bundle.min.css']) --}}

    @stack('styles')

    <!-- Layout config Js -->
    <script src="{{ url('/assets/js/layout.js') }}"></script>

    <!-- Bootstrap Css -->
    @vite(['resources/assets/css/bootstrap.min.css'])

    @vite(['resources/assets/css/custom-bootstrap.css'])

    <!-- Icons Css -->
    @vite(['resources/assets/css/icons.min.css'])
    @vite(['resources/assets/css/icons5.min.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    {{-- <link href="https://dev1.routepro.cloud/bo/assets/css/icons.min.css" rel="stylesheet" type="text/css"> --}}

    <!-- App Css-->
    @vite(['resources/assets/css/app.min.css'])

    <!-- custom Css-->
    @vite(['resources/assets/css/custom-table.css'])
    @vite(['resources/assets/css/custom.css'])


    @include('include.head')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <x-loaders.page-preloader />

</head>

<body>

    <div id="layout-wrapper">

        @include('include.header')

        @include('include.sidebar')

        <div class="main-content">
            @yield('content')
            @include('include.footer')
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        @stack('scripts')
        <x-notification.toastify />
    </div>

    @include('include.setting')

    <!-- JAVASCRIPT -->

    <script src="{{ url('/assets/libs/node-waves/waves.min.js') }}"></script>

    <!-- App js -->


    @vite(['resources/js/app.js'])

    {{-- <script src="{{ url('assets/js/custom-table.js') }}"></script> --}}


</body>

</html>
