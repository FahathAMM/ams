<!doctype html>
<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar="light" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="F2 Studio" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | AMS</title>
    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <link rel="shortcut icon" href="{{ url('/assets/images/favicon.ico') }}" />

    @livewireStyles

    @include('include.head')

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


        <x-notification.toastify />
    </div>


    @include('include.setting')

    @livewireScripts

    @include('include.foot')


</body>

</html>
