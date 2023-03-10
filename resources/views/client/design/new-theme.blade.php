@php
    $admin_settings = getAdminSettings();
    $main_screen = isset($admin_settings['theme_main_screen_demo']) ? $admin_settings['theme_main_screen_demo'] : '';
    $category_screen = isset($admin_settings['theme_category_screen_demo']) ? $admin_settings['theme_category_screen_demo'] : '';
@endphp

@extends('client.layouts.client-layout')

@section('title', 'New Theme')

@section('content')

<section class="theme_section">
    <div class="main_section_inr">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('design.theme') }}">Themes</a></li>
                <li class="breadcrumb-item active">New Theme</li>
            </ol>
        </nav>
        <div class="row">
            <form action="{{ route('design.theme-store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                    <div class="theme_change_sec">
                        <div class="theme_name">
                            <h2 class="form-group">
                                <input type="text" name="theme_name" id="theme_name" class="form-control border-0 {{ ($errors->has('theme_name')) ? 'is-invalid' : '' }}" placeholder="Enter Theme Name">
                                @if($errors->has('theme_name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('theme_name') }}
                                    </div>
                                @endif
                            </h2>
                        </div>
                        <div class="theme_change_sec_inr">
                            <div class="accordion" id="accordionExample">

                                {{-- Main Page Section --}}
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Main Screen</button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="main_theme_color">
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-7">
                                                                <span>Header Color</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="header_color" name="header_color" class="form-control me-2 p-0" value="" onchange="changeVal('header_color','header_color_input')">
                                                                    <input type="text" id="header_color_input" class="form-control" onkeyup="changeColor('header_color_input','header_color')" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-7">
                                                                <span>Sticky Header</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <label class="switch">
                                                                    <input type="checkbox" name="sticky_header" id="sticky_header" value="1">
                                                                    <span class="slider round">
                                                                        <i class="fa-solid fa-circle-check check_icon"></i>
                                                                        <i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-7">
                                                                <span>Language Box Position</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <select name="language_bar_position" id="language_bar_position" class="form-select header-select">
                                                                    <option value="right">Right</option>
                                                                    <option value="left" selected>Left</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-7">
                                                                <span>Logo Position</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <select name="logo_position" id="logo_position" class="form-select header-select">
                                                                    <option value="right">Right</option>
                                                                    <option value="left">Left</option>
                                                                    <option value="center" selected>Center</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-7">
                                                                <span>Search Box Position</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <select name="search_box_position" id="search_box_position" class="form-select header-select">
                                                                    <option value="right" selected>Right</option>
                                                                    <option value="left">Left</option>
                                                                    <option value="center">Center</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-7">
                                                                <span>Search Box Icon Color</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="search_box_icon_color" name="search_box_icon_color" class="form-control me-2 p-0" value="" onchange="changeVal('search_box_icon_color','search_box_icon_color_input')">
                                                                    <input id="search_box_icon_color_input" type="text" class="form-control" value="" onkeyup="changeColor('search_box_icon_color_input','search_box_icon_color')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-7">
                                                                <span>Banner Position</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <select name="banner_position" id="banner_position" class="form-select">
                                                                    <option value="top">Top</option>
                                                                    <option value="bottom">Bottom</option>
                                                                    <option value="hide">Hidden</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-7">
                                                                <span>Banner Type</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <select name="banner_type" id="banner_type" class="form-select">
                                                                    <option value="text">Text</option>
                                                                    <option value="image">Image</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-7">
                                                                <span>Background Color</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="background_color" name="background_color" class="form-control me-2 p-0" value="" onchange="changeVal('background_color','background_color_input')">
                                                                    <input id="background_color_input" type="text" class="form-control" value="" onkeyup="changeColor('background_color_input','background_color')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-7">
                                                                <span>Font Color</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="font_color" name="font_color" class="form-control me-2 p-0" value="" onchange="changeVal('font_color','font_color_input')">
                                                                    <input id="font_color_input" type="text" class="form-control" value="" onkeyup="changeColor('font_color_input','font_color')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-7">
                                                                <span>Label Color</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="label_color" name="label_color" class="form-control me-2 p-0" value="" onchange="changeVal('label_color','label_color_input')">
                                                                    <input id="label_color_input" type="text" class="form-control" value="" onkeyup="changeColor('label_color_input','label_color')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-7">
                                                                <span>Social Media Icons Color</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="social_media_icon_color" name="social_media_icon_color" class="form-control me-2 p-0" value="" onchange="changeVal('social_media_icon_color','social_media_icon_color_input')">
                                                                    <input id="social_media_icon_color_input" type="text" class="form-control" value="" onkeyup="changeColor('social_media_icon_color_input','social_media_icon_color')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="preview_img">
                                                        @if(!empty($main_screen))
                                                            <img src="{{ $main_screen }}" class="w-100">
                                                            {{-- <img src="{{ asset('public/client_images/not-found/theme_main_screen.png') }}" class="w-100"> --}}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Item Page Section --}}
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Within Item Screen
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="main_theme_color">
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Categories Bar Color</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="categories_bar_color" name="categories_bar_color" class="form-control me-2 p-0" value="" onchange="changeVal('categories_bar_color','categories_bar_color_input')">
                                                                    <input id="categories_bar_color_input" type="text" class="form-control" value="" onkeyup="changeColor('categories_bar_color_input','categories_bar_color')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Category Bar Type</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select name="category_bar_type" id="category_bar_type" class="form-select">
                                                                    <option value="8px">Square</option>
                                                                    <option value="50%">Circle</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Category Bar Fonts Color</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="menu_bar_font_color" name="menu_bar_font_color" class="form-control me-2 p-0" value="" onchange="changeVal('menu_bar_font_color','menu_bar_font_color_input')">
                                                                    <input id="menu_bar_font_color_input" type="text" class="form-control" value="" onkeyup="changeColor('menu_bar_font_color_input','menu_bar_font_color')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Category Title & Description Fonts Color</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="category_title_and_description_color" name="category_title_and_description_color" class="form-control me-2 p-0" value="" onchange="changeVal('category_title_and_description_color','category_title_and_description_color_input')">
                                                                    <input id="category_title_and_description_color_input" type="text" class="form-control" value="" onkeyup="changeColor('category_title_and_description_color_input','category_title_and_description_color')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Price Color</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="price_color" name="price_color" class="form-control me-2 p-0" value="" onchange="changeVal('price_color','price_color_input')">
                                                                    <input id="price_color_input" type="text" class="form-control" value="" onkeyup="changeColor('price_color_input','price_color')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Item Box Shadow</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="switch">
                                                                    <input type="checkbox" name="item_box_shadow" id="item_box_shadow" value="1">
                                                                    <span class="slider round">
                                                                        <i class="fa-solid fa-circle-check check_icon"></i>
                                                                        <i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Item Box Shadow Color</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="item_box_shadow_color" name="item_box_shadow_color" class="form-control me-2 p-0" value="" onchange="changeVal('item_box_shadow_color','item_box_shadow_color_input')">
                                                                    <input id="item_box_shadow_color_input" type="text" class="form-control" value="" onkeyup="changeColor('item_box_shadow_color_input','item_box_shadow_color')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Item Box Shadow Thickness</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select name="item_box_shadow_thickness" id="item_box_shadow_thickness" class="form-select">
                                                                    <option value="1px">Light</option>
                                                                    <option value="3px">Medium</option>
                                                                    <option value="5px">Bold</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Item Divider</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label class="switch">
                                                                    <input type="checkbox" name="item_divider" id="item_divider" value="1">
                                                                    <span class="slider round">
                                                                        <i class="fa-solid fa-circle-check check_icon"></i>
                                                                        <i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Item Divider Color</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="item_divider_color" name="item_divider_color" class="form-control me-2 p-0" value="" onchange="changeVal('item_divider_color','item_divider_color_input')">
                                                                    <input id="item_divider_color_input" type="text" class="form-control" value="" onkeyup="changeColor('item_divider_color_input','item_divider_color')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Item Divider Thickness</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <input type="number" name="item_divider_thickness" id="item_divider_thickness" class="form-control" value="5">
                                                                    <code>Enter Thickness in Pexels</code>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Item Divider Type</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select name="item_divider_type" id="item_divider_type" class="form-select">
                                                                    <option value="solid">Solid</option>
                                                                    <option value="dotted">Dotted</option>
                                                                    <option value="dashed">Dashed</option>
                                                                    <option value="double">Double</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Item Divider Position</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <select name="item_divider_position" id="item_divider_position" class="form-select">
                                                                    <option value="top">Top</option>
                                                                    <option value="bottom">Bottom</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Item Divider Font Color</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="item_divider_font_color" name="item_divider_font_color" class="form-control me-2 p-0" value="" onchange="changeVal('item_divider_font_color','item_divider_font_color_input')">
                                                                    <input id="item_divider_font_color_input" type="text" class="form-control" value="" onkeyup="changeColor('item_divider_font_color_input','item_divider_font_color')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Tag Font Color</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="tag_font_color" name="tag_font_color" class="form-control me-2 p-0" value="" onchange="changeVal('tag_font_color','tag_font_color_input')">
                                                                    <input id="tag_font_color_input" type="text" class="form-control" value="" onkeyup="changeColor('tag_font_color_input','tag_font_color')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Tag Label Color</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="tag_label_color" name="tag_label_color" class="form-control me-2 p-0" value="" onchange="changeVal('tag_label_color','tag_label_color_input')">
                                                                    <input id="tag_label_color_input" type="text" class="form-control" value="" onkeyup="changeColor('tag_label_color_input','tag_label_color')">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-4">
                                                                <span>Today Special Icon</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="form-group align-items-center">
                                                                    <input type="file" name="today_special_icon" id="today_special_icon" class="form-control {{ ($errors->has('today_special_icon')) ? 'is-invalid' : '' }}">
                                                                    @if($errors->has('today_special_icon'))
                                                                        <div class="invalid-feedback">
                                                                            {{ $errors->first('today_special_icon') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-4">
                                                                <span>Theme Prview Image</span>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <div class="form-group align-items-center">
                                                                    <input type="file" name="theme_preview_image" id="theme_preview_image" class="form-control {{ ($errors->has('theme_preview_image')) ? 'is-invalid' : '' }}">
                                                                    @if($errors->has('theme_preview_image'))
                                                                        <div class="invalid-feedback">
                                                                            {{ $errors->first('theme_preview_image') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="preview_img">
                                                        @if(!empty($category_screen))
                                                            <img src="{{ $category_screen }}" class="w-100">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-3">
                    <button class="btn btn-success">S A V E</button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

{{-- Custom JS --}}
@section('page-js')

    <script type="text/javascript">

        function changeVal(colorPickerID,textID)
        {
            var value = $('#'+colorPickerID).val();
            $('#'+textID).val(value);
        }

        function changeColor(textID,colorPickerID)
        {
            var value = $('#'+textID).val();
            $('#'+colorPickerID).val(value);
        }

        //

        // $(".header-select").on('focus', function () {
        //     // Store the current value on focus and on change
        //     previous = this.value;
        // }).change(function(){
        //     var position1 = $(this).val();
        //     var selectID = $(this).attr("id");

        //     if(selectID == 'language_bar_position')
        //     {
        //         var position2 = $('#logo_position').val();
        //         var position3 = $('#search_box_position').val();

        //         if(position1 == position2 || position1 == position3)
        //         {
        //             $("#"+selectID).val(previous).prop('selected', true);
        //             alert('Please Select Diffrent Values');
        //         }
        //     }
        // });

    </script>

@endsection
