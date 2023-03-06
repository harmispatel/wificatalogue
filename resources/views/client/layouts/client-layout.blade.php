<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @include('client.layouts.client-css')
</head>

@php
    $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : '';
    $shop_slug = isset(Auth::user()->hasOneShop->shop['shop_slug']) ? Auth::user()->hasOneShop->shop['shop_slug'] : '';
@endphp

<body>

    {{-- Preview Modal --}}
    <div class="modal fade preview_modal" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Preview</h5>
                    <button type="button" style="width: 75px;" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="mob_preview position-relative">
                                <img src="{{ asset('public/client_images/mobile_view/mobile_view_1.png') }}" class="w-100 mobile_img" alt="">
                                <div class="mob_preview_inr">
                                    <iframe src="{{ route('restaurant',$shop_slug) }}" frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
