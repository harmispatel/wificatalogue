<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @include('shop.shop-css')
</head>
<body>

    {{-- Navbar --}}
    @include('shop.shop-navbar')

    {{-- Main Content --}}
    <main id="main" class="main">
        @yield('content')
    </main>

    {{-- JS --}}
    @include('shop.shop-js')

    {{-- Custom JS --}}
    @yield('page-js')

</body>
</html>
