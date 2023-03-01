@php
    // Shop Settings
    $shop_settings = getClientSettings($shop_details['id']);

    // Shop Name
    $shop_name = (isset($shop_details['name']) && !empty($shop_details['name'])) ? $shop_details['name'] : "Restaurant Managament - Home";

    // Default Logo
    $default_logo = asset('public/client_images/not-found/your_logo_1.png');

    // Shop Logo
    $shop_logo = (isset($shop_settings['shop_view_header_logo']) && !empty($shop_settings['shop_view_header_logo'])) ? $shop_settings['shop_view_header_logo'] : "";

    // Language Details
    $language_details = getLangDetailsbyCode($current_lang_code);

    // Get Banner Settings
    $banner_setting = getBannerSetting($shop_details['id']);
    $banner_key = $language_details['code']."_image";
    $banner_text_key = $language_details['code']."_title";
    $banner_image = isset($banner_setting[$banner_key]) ? $banner_setting[$banner_key] : "";
    $banner_text = isset($banner_setting[$banner_text_key]) ? $banner_setting[$banner_text_key] : "";

@endphp

@extends('shop.shop-layout')

@section('title', $shop_name)

@section('content')

    <input type="hidden" name="shop_id" id="shop_id" value="{{ encrypt($shop_details['id']); }}">

    <div class="banner-image">
        @if(!empty($banner_image) && file_exists('public/client_uploads/banners/'.$banner_image))
            <img src="{{ asset('public/client_uploads/banners/'.$banner_image) }}" class="w-100">
        @else
            @if(!empty($banner_text))
                <h4 class="text-center">{{ $banner_text }}</h4>
            @endif
        @endif
    </div>

    <section class="sec_main">
        <div class="container" id="CategorySection">

            @if(count($categories) > 0)
                <div class="menu_list">
                    @foreach ($categories as $category)

                        @php
                            $default_cat_img = asset('public/client_images/not-found/no_image_1.jpg');
                            $name_code = $current_lang_code."_name";
                        @endphp

                        <div class="menu_list_item">
                            <a href="{{ route('items.preview',[$shop_details['id'],$category->id]) }}">
                                @if(!empty($category->image) && file_exists('public/client_uploads/categories/'.$category->image))
                                    <img src="{{ asset('public/client_uploads/categories/'.$category->image) }}" class="w-100">
                                @else
                                    <img src="{{ $default_cat_img }}" class="w-100">
                                @endif
                                <h3 class="item_name">{{ isset($category->$name_code) ? $category->$name_code : '' }}</h3>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <h3 class="text-center">Categories not Found.</h3>
            @endif
        </div>
    </section>


    <footer class="footer text-center">
        <div class="container">
            <div class="footer-inr">
                <h4>{{ isset($shop_settings['homepage_intro']) ? $shop_settings['homepage_intro'] : '[Intro Here]' }}</h4>

                <div class="footer_media">
                    <h3>Find Us</h3>
                    <ul>
                        {{-- Instagram Link --}}
                        @if(isset($shop_settings['instagram_link']) && !empty($shop_settings['instagram_link']))
                            <li>
                                <a href="{{ $shop_settings['instagram_link'] }}"><i class="fa-brands fa-square-instagram"></i></a>
                            </li>
                        @endif

                        {{-- Twitter Link --}}
                        @if(isset($shop_settings['twitter_link']) && !empty($shop_settings['twitter_link']))
                            <li>
                                <a href="{{ $shop_settings['twitter_link'] }}"><i class="fa-brands fa-square-twitter"></i></a>
                            </li>
                        @endif

                        {{-- Facebook Link --}}
                        @if(isset($shop_settings['facebook_link']) && !empty($shop_settings['facebook_link']))
                            <li>
                                <a href="{{ $shop_settings['facebook_link'] }}"><i class="fa-brands fa-square-facebook"></i></a>
                            </li>
                        @endif

                        {{-- FourSquare Link --}}
                        @if(isset($shop_settings['foursquare_link']) && !empty($shop_settings['foursquare_link']))
                            <li>
                                <a href="{{ $shop_settings['foursquare_link'] }}"><i class="fa-brands fa-foursquare"></i></a>
                            </li>
                        @endif

                        {{-- TripAdvisor Link --}}
                        @if(isset($shop_settings['tripadvisor_link']) && !empty($shop_settings['tripadvisor_link']))
                            <li>
                                <a href="{{ $shop_settings['tripadvisor_link'] }}"><img src="{{ asset('public/client_images/bs-icon/tripadvisor_green.png') }}" style="width: 37px; height: 35px;"></a>
                            </li>
                        @endif

                        {{-- Website Link --}}
                        @if(isset($shop_settings['website_url']) && !empty($shop_settings['website_url']))
                            <li>
                                <a href="{{ $shop_settings['website_url'] }}"><i class="fa-solid fa-globe"></i></a>
                            </li>
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <div class="loader">
        <div class="restaurant-loader">
            <div class="restaurant-loader-inner"></div>
        </div>
    </div>

@endsection

{{-- Page JS Function --}}
@section('page-js')

    <script type="text/javascript">

        // Document Ready Function
        $(document).ready(function()
        {
            // TimeOut for Intro
            setTimeout(() => {
                $('.loader').hide();
            }, 700);

        });


        // Function for Get Filterd Categories
        $('#search').on('keyup',function()
        {
            var keywords = $(this).val();
            var shopID = $('#shop_id').val();

            $.ajax({
                type: "POST",
                url: '{{ route("shop.categories.search") }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'keywords':keywords,
                    'shopID':shopID,
                },
                dataType: 'JSON',
                success: function(response)
                {
                    if (response.success == 1)
                    {
                        $('#CategorySection').html('');
                        $('#CategorySection').append(response.data);
                    }
                    else
                    {
                        console.log(response.message);
                    }
                }
            });

        });


        // Error Messages
        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}')
        @endif

    </script>

@endsection
