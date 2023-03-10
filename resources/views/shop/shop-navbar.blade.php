@php

    $language_bar_position = isset($theme_settings['language_bar_position']) ? $theme_settings['language_bar_position'] : '';
    $logo_position = isset($theme_settings['logo_position']) ? $theme_settings['logo_position'] : '';
    $search_box_position = isset($theme_settings['search_box_position']) ? $theme_settings['search_box_position'] : '';
@endphp

<header class="header_preview header-sticky">
    <nav class="navbar navbar-light bg-light">
        <div class="container">

            @if(($language_bar_position != $logo_position) && ($language_bar_position != $search_box_position) && ($logo_position != $search_box_position) && ($logo_position != $language_bar_position) && ($search_box_position != $language_bar_position) && ($search_box_position != $logo_position))

                {{-- Left Position --}}
                @if($language_bar_position == 'left')
                    <div class="lang_select">
                        <a class="lang_bt" > <x-dynamic-component width="35px" component="flag-language-{{ $language_details['code'] }}" /> </a>
                        {{-- <a class="lang_bt" style="text-decoration: none; color:black; font-weight:700;cursor: pointer;"><i class="fa-solid fa-language"></i> {{ isset($language_details['name']) ? strtoupper($language_details['name']) : "" }}</a> --}}
                        @if(count($additional_languages) > 0)
                            <div class="lang_inr">
                                <div class="text-end">
                                    <button class="btn close_bt"><i class="fa-solid fa-chevron-left"></i></button>
                                </div>
                                <ul class="lang_ul">
                                    @if(isset($primary_language_details) && !empty($primary_language_details))
                                        <li>
                                                <x-dynamic-component width="35px" component="flag-language-{{ $primary_language_details['code'] }}" />
                                                <a onclick="changeLanguage('{{ $primary_language_details['code'] }}')" style="cursor: pointer;">{{ isset($primary_language_details['name']) ? $primary_language_details['name'] : '' }}</a>
                                        </li>
                                    @endif
                                    @foreach ($additional_languages as $language)
                                        @php
                                            $langCode = isset($language->language['code']) ? $language->language['code'] : "";
                                        @endphp
                                        <li>
                                            <x-dynamic-component width="35px" component="flag-language-{{ $langCode }}" />
                                            <a onclick="changeLanguage('{{ $langCode }}')" style="cursor: pointer;">{{ isset($language->language['name']) ? $language->language['name'] : "" }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @elseif ($logo_position == 'left')
                    <a class="navbar-brand" href="{{ route('restaurant',$shop_details['shop_slug']) }}">
                        @if(!empty($shop_logo) && file_exists('public/client_uploads/top_logos/'.$shop_logo))
                            <img src="{{ asset('public/client_uploads/top_logos/'.$shop_logo) }}" width="120">
                        @else
                            <img src="{{ $default_logo }}" width="120">
                        @endif
                    </a>
                @elseif ($search_box_position == 'left')
                    <button class="btn search_bt" id="openSearchBox">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <button class="btn search_bt d-none" id="closeSearchBox">
                        <i class="fa-solid fa-times"></i>
                    </button>
                @endif

                {{-- Center Position --}}
                @if($logo_position == 'center')
                    <a class="navbar-brand" href="{{ route('restaurant',$shop_details['shop_slug']) }}">
                        @if(!empty($shop_logo) && file_exists('public/client_uploads/top_logos/'.$shop_logo))
                            <img src="{{ asset('public/client_uploads/top_logos/'.$shop_logo) }}" width="120">
                        @else
                            <img src="{{ $default_logo }}" width="120">
                        @endif
                    </a>
                @elseif ($search_box_position == 'center')
                    <button class="btn search_bt" id="openSearchBox">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <button class="btn search_bt d-none" id="closeSearchBox">
                        <i class="fa-solid fa-times"></i>
                    </button>
                @endif

                {{-- Right Position --}}
                @if($language_bar_position == 'right')
                    <div class="lang_select">
                        <a class="lang_bt" > <x-dynamic-component width="35px" component="flag-language-{{ $language_details['code'] }}" /> </a>
                        {{-- <a class="lang_bt" style="text-decoration: none; color:black; font-weight:700;cursor: pointer;"><i class="fa-solid fa-language"></i> {{ isset($language_details['name']) ? strtoupper($language_details['name']) : "" }}</a> --}}
                        @if(count($additional_languages) > 0)
                            <div class="lang_inr">
                                <div class="text-end">
                                    <button class="btn close_bt"><i class="fa-solid fa-chevron-left"></i></button>
                                </div>
                                <ul class="lang_ul">
                                    @if(isset($primary_language_details) && !empty($primary_language_details))
                                        <li>
                                                <x-dynamic-component width="35px" component="flag-language-{{ $primary_language_details['code'] }}" />
                                                <a onclick="changeLanguage('{{ $primary_language_details['code'] }}')" style="cursor: pointer;">{{ isset($primary_language_details['name']) ? $primary_language_details['name'] : '' }}</a>
                                        </li>
                                    @endif
                                    @foreach ($additional_languages as $language)
                                        @php
                                            $langCode = isset($language->language['code']) ? $language->language['code'] : "";
                                        @endphp
                                        <li>
                                            <x-dynamic-component width="35px" component="flag-language-{{ $langCode }}" />
                                            <a onclick="changeLanguage('{{ $langCode }}')" style="cursor: pointer;">{{ isset($language->language['name']) ? $language->language['name'] : "" }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @elseif ($logo_position == 'right')
                    <a class="navbar-brand" href="{{ route('restaurant',$shop_details['shop_slug']) }}">
                        @if(!empty($shop_logo) && file_exists('public/client_uploads/top_logos/'.$shop_logo))
                            <img src="{{ asset('public/client_uploads/top_logos/'.$shop_logo) }}" width="120">
                        @else
                            <img src="{{ $default_logo }}" width="120">
                        @endif
                    </a>
                @elseif ($search_box_position == 'right')
                    <button class="btn search_bt" id="openSearchBox">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <button class="btn search_bt d-none" id="closeSearchBox">
                        <i class="fa-solid fa-times"></i>
                    </button>
                @endif

                <div class="search_input">
                    <input type="text" class="form-control w-100" name="search" id="search">
                </div>

            @else
                <div class="lang_select">
                    <a class="lang_bt" > <x-dynamic-component width="35px" component="flag-language-{{ $language_details['code'] }}" /> </a>
                    {{-- <a class="lang_bt" style="text-decoration: none; color:black; font-weight:700;cursor: pointer;"><i class="fa-solid fa-language"></i> {{ isset($language_details['name']) ? strtoupper($language_details['name']) : "" }}</a> --}}
                    @if(count($additional_languages) > 0)
                        <div class="lang_inr">
                            <div class="text-end">
                                <button class="btn close_bt"><i class="fa-solid fa-chevron-left"></i></button>
                            </div>
                            <ul class="lang_ul">
                                @if(isset($primary_language_details) && !empty($primary_language_details))
                                    <li>
                                            <x-dynamic-component width="35px" component="flag-language-{{ $primary_language_details['code'] }}" />
                                            <a onclick="changeLanguage('{{ $primary_language_details['code'] }}')" style="cursor: pointer;">{{ isset($primary_language_details['name']) ? $primary_language_details['name'] : '' }}</a>
                                    </li>
                                @endif
                                @foreach ($additional_languages as $language)
                                    @php
                                        $langCode = isset($language->language['code']) ? $language->language['code'] : "";
                                    @endphp
                                    <li>
                                        <x-dynamic-component width="35px" component="flag-language-{{ $langCode }}" />
                                        <a onclick="changeLanguage('{{ $langCode }}')" style="cursor: pointer;">{{ isset($language->language['name']) ? $language->language['name'] : "" }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <a class="navbar-brand" href="{{ route('restaurant',$shop_details['shop_slug']) }}">
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
            @endif

        </div>
    </nav>
</header>
