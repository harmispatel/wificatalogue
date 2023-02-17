<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @include('client.layouts.client-css')
</head>

<body>
    {{-- Navbar --}}
    @include('client.layouts.client-navbar')

    {{-- Sidebar --}}
    @include('client.layouts.client-sidebar')

    {{-- Main Content --}}
    <main id="main" class="main">
        @yield('content')
    </main>
    <!-- End #main -->

    {{-- Footer --}}
    @include('client.layouts.client-footer')

    {{-- Uplink --}}
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    {{-- Client JS --}}
    @include('client.layouts.client-js')

    @yield('page-js');

</body>

</html>
