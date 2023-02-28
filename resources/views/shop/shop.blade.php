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

@endphp

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $shop_name }}</title>

	<!-- bootstrap css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('public/client/assets/css/bootstrap.min.css') }}">

	<!-- custom css -->
	<link rel="stylesheet" type="text/css" href="{{ asset('public/client/assets/css/custom.css') }}">

	<!-- font awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>

</head>
<body>

        <input type="hidden" name="shop_id" id="shop_id" value="{{ encrypt($shop_details['id']); }}">

		<nav class="navbar navbar-light bg-light">
		  	<div class="container">
		  		<div class="lang_select">
		  			{{-- <a class="lang_bt" ><i class="fa-solid fa-language" style="font-size: 35px;"></i></a> --}}
		  			<a class="lang_bt" style="text-decoration: none; color:black; font-weight:700;cursor: pointer;"><i class="fa-solid fa-language"></i> {{ isset($language_details['name']) ? strtoupper($language_details['name']) : "" }}</a>
                    @if(count($additional_languages) > 0)
                        <div class="lang_inr">
                            <div class="text-end">
                                <button class="btn close_bt"><i class="fa-solid fa-chevron-left"></i></button>
                            </div>
                            <ul class="lang_ul">
                                @foreach ($additional_languages as $language)
                                    @php
                                        $langCode = isset($language->language['code']) ? $language->language['code'] : "";
                                    @endphp
                                    <li><a onclick="changeLanguage('{{ $langCode }}')" style="cursor: pointer;">{{ isset($language->language['name']) ? $language->language['name'] : "" }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
		  		</div>
		    	<a class="navbar-brand" href="{{ route('restaurant',$shop_details['id']) }}">
                    @if(!empty($shop_logo) && file_exists('public/client_uploads/top_logos/'.$shop_logo))
                        <img src="{{ asset('public/client_uploads/top_logos/'.$shop_logo) }}" width="120">
                    @else
		    		    <img src="{{ $default_logo }}" width="120">
                    @endif
		    	</a>
				<button class="btn search_bt" id="openSearchBox">
					<i class="fa-solid fa-magnifying-glass"></i>
				</button>
				<button class="btn search_bt d-none" id="closeSearchBox">
					<i class="fa-solid fa-times"></i>
				</button>
				<div class="search_input">
					<input type="text" class="form-control w-100" name="search" id="search">
				</div>
		  	</div>
		</nav>

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
                                <a>
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

        <script src="{{ asset('public/client/assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('public/client/assets/js/jquery.min.js') }}"></script>

        @include('shop.custom-js')

        <script type="text/javascript">

            //
            $(document).ready(function(){
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

        </script>

</body>
</html>

