@php
    // Shop Settings
    $shop_settings = getClientSettings($shop_details['id']);

    // Shop Name
    $shop_name = (isset($shop_details['name']) && !empty($shop_details['name'])) ? $shop_details['name'] : "Restaurant Managament - Home";

    // Default Logo
    $default_logo = asset('public/client_images/not-found/your_logo_1.png');

    // Default Image
    $default_image = asset('public/client_images/not-found/no_image_1.jpg');

    // Shop Logo
    $shop_logo = (isset($shop_settings['shop_view_header_logo']) && !empty($shop_settings['shop_view_header_logo'])) ? $shop_settings['shop_view_header_logo'] : "";

    // Language Details
    $language_details = getLangDetailsbyCode($current_lang_code);

    // Name Key
    $name_key = $current_lang_code."_name";

    // Description Key
    $description_key = $current_lang_code."_description";

    // Price Key
    $price_key = $current_lang_code."_price";

    // Current Category
    $current_cat_id = isset($cat_details['id']) ? $cat_details['id'] : '';

@endphp


@extends('shop.shop-layout')

@section('title', 'Items')

@section('content')

<section class="item_sec_main">
	<div class="container">
		<div class="item_box_main">

            {{-- Categories Tabs --}}
			<ul class="nav nav-tabs" id="myTab" role="tablist">.

                @if(count($categories) > 0)
                    @foreach ($categories as $cat)
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('items.preview',[$shop_details['id'],$cat->id]) }}" class="nav-link {{ ($cat->id == $current_cat_id) ? 'active' : '' }}">
                                <div class="img_box">
                                    @if(!empty($cat->image) && file_exists('public/client_uploads/categories/'.$cat->image))
                                        <img src="{{ asset('public/client_uploads/categories/'.$cat->image) }}" class="w-100">
                                    @else
                                        <img src="{{ $default_image }}" class="w-100">
                                    @endif
                                    <span>{{ isset($cat->$name_key) ? $cat->$name_key : $cat->name }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @endif
			</ul>

				<div class="item_list_div">
                    <h3 class="mb-3">{{ isset($cat_details[$name_key]) ? $cat_details[$name_key] : $cat_details['name'] }}</h3>

                    <div class="item_inr_info">

                        @if(count($cat_tags) > 0)
                            {{-- Tags Section --}}
                            <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">All</button>
                                </li>

                                @foreach ($cat_tags as $tag)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link text-capitalize" id="{{ $tag['id'] }}-tab" data-bs-toggle="tab" data-bs-target="#tag{{ $tag['id'] }}" type="button" role="tab" aria-controls="tag{{ $tag['id'] }}" aria-selected="false">{{ (isset($tag[$name_key])) ? $tag[$name_key] : $tag['name'] }}</button>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                                    <div class="item_inr_info_sec">
                                        @if(count($all_items) > 0)
                                            @foreach ($all_items as $item)
                                                <div class="single_item_inr">

                                                    {{-- Image Section --}}
                                                    @if(!empty($item['image']) && file_exists('public/client_uploads/items/'.$item['image']))
                                                        <div class="item_image">
                                                            <img src="{{ asset('public/client_uploads/items/'.$item['image']) }}">
                                                        </div>
                                                    @endif

                                                    {{-- Name Section --}}
                                                    <h3>{{ (isset($item[$name_key]) && !empty($item[$name_key])) ? $item[$name_key] : $item['name'] }}</h3>

                                                    {{-- New Product Image --}}
                                                    @if($item['is_new'] == 1)
                                                        <img class="is_new tag-img" src="{{ asset('public/client_images/bs-icon/new.png') }}">
                                                    @endif

                                                    {{-- Signature Image --}}
                                                    @if($item['as_sign'] == 1)
                                                        <img class="is_sign tag-img" src="{{ asset('public/client_images/bs-icon/signature.png') }}">
                                                    @endif

                                                    {{-- Day Special Image --}}
                                                    @if($item['day_special'] == 1)
                                                        <img class="is_special tag-img" src="{{ asset('public/client_images/bs-icon/special.png') }}">
                                                    @endif

                                                    {{-- Ingredient Section --}}
                                                    @php
                                                        $ingrediet_arr = (isset($item['ingredients']) && !empty($item['ingredients'])) ? unserialize($item['ingredients']) : [];
                                                    @endphp

                                                    @if(count($ingrediet_arr) > 0)
                                                        <div>
                                                            @foreach ($ingrediet_arr as $val)
                                                                @php
                                                                    $ingredient = getIngredientDetail($val);
                                                                    $ing_icon = isset($ingredient['icon']) ? $ingredient['icon'] : '';
                                                                @endphp

                                                                @if(!empty($ing_icon) && file_exists('public/admin_uploads/ingredients/'.$ing_icon))
                                                                    <img src="{{ asset('public/admin_uploads/ingredients/'.$ing_icon) }}" width="20px">
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                    {{-- Description Section --}}
                                                    <p>{{ (isset($item[$description_key]) && !empty($item[$description_key])) ? $item[$description_key] : $item['description'] }}</p>

                                                    {{-- Price Section --}}
                                                    <ul class="price_ul">
                                                        @php
                                                            $price_arr = (isset($item[$price_key]) && !empty($item[$price_key])) ? unserialize($item[$price_key]) : [];
                                                            $price = isset($price_arr['price']) ? $price_arr['price'] : [];
                                                            $label = isset($price_arr['label']) ? $price_arr['label'] : [];
                                                        @endphp

                                                        @if(count($price) > 0)
                                                            @foreach ($price as $key => $value)
                                                                <li>
                                                                    <p>{{ isset($label[$key]) ? $label[$key] : '' }} : <span>{{ $value }}</span></p>
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                @foreach ($cat_tags as $tag)

                                    @php
                                        $tag_items = getTagsProducts($tag['tag_id'],$cat_details['id']);
                                    @endphp

                                    <div class="tab-pane fade show" id="tag{{ $tag['id'] }}" role="tabpanel" aria-labelledby="{{ $tag['id'] }}-tab">
                                        @if(count($tag_items) > 0)
                                            @foreach ($tag_items as $item)
                                                <div class="single_item_inr">

                                                    {{-- Image Section --}}
                                                    @if(!empty($item->product['image']) && file_exists('public/client_uploads/items/'.$item->product['image']))
                                                        <div class="item_image">
                                                            <img src="{{ asset('public/client_uploads/items/'.$item->product['image']) }}">
                                                        </div>
                                                    @endif

                                                    {{-- Name Section --}}
                                                    <h3>{{ (isset($item->product[$name_key]) && !empty($item->product[$name_key])) ? $item->product[$name_key] : $item->product['name'] }}</h3>

                                                    {{-- New Product Image --}}
                                                    @if($item->product['is_new'] == 1)
                                                        <img class="is_new tag-img" src="{{ asset('public/client_images/bs-icon/new.png') }}">
                                                    @endif

                                                    {{-- Signature Image --}}
                                                    @if($item->product['as_sign'] == 1)
                                                        <img class="is_sign tag-img" src="{{ asset('public/client_images/bs-icon/signature.png') }}">
                                                    @endif

                                                    {{-- Day Special Image --}}
                                                    @if($item->product['day_special'] == 1)
                                                        <img class="is_special tag-img" src="{{ asset('public/client_images/bs-icon/special.png') }}">
                                                    @endif

                                                    {{-- Ingredient Section --}}
                                                    @php
                                                        $ingrediet_arr = (isset($item->product['ingredients']) && !empty($item->product['ingredients'])) ? unserialize($item->product['ingredients']) : [];
                                                    @endphp

                                                    @if(count($ingrediet_arr) > 0)
                                                        <div>
                                                            @foreach ($ingrediet_arr as $val)
                                                                @php
                                                                    $ingredient = getIngredientDetail($val);
                                                                    $ing_icon = isset($ingredient['icon']) ? $ingredient['icon'] : '';
                                                                @endphp

                                                                @if(!empty($ing_icon) && file_exists('public/admin_uploads/ingredients/'.$ing_icon))
                                                                    <img src="{{ asset('public/admin_uploads/ingredients/'.$ing_icon) }}" width="20px">
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif

                                                    {{-- Description Section --}}
                                                    <p>{{ (isset($item->product[$description_key]) && !empty($item->product[$description_key])) ? $item->product[$description_key] : $item->product['description'] }}</p>

                                                    {{-- Price Section --}}
                                                    <ul class="price_ul">
                                                        @php
                                                            $price_arr = (isset($item->product[$price_key]) && !empty($item->product[$price_key])) ? unserialize($item->product[$price_key]) : [];
                                                            $price = isset($price_arr['price']) ? $price_arr['price'] : [];
                                                            $label = isset($price_arr['label']) ? $price_arr['label'] : [];
                                                        @endphp

                                                        @if(count($price) > 0)
                                                            @foreach ($price as $key => $value)
                                                                <li>
                                                                    <p>{{ isset($label[$key]) ? $label[$key] : '' }} : <span>{{ $value }}</span></p>
                                                                </li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="item_inr_info_sec">
                                @if(count($all_items) > 0)
                                    @foreach ($all_items as $item)
                                        <div class="single_item_inr">

                                            {{-- Image Section --}}
                                            @if(!empty($item['image']) && file_exists('public/client_uploads/items/'.$item['image']))
                                                <div class="item_image">
                                                    <img src="{{ asset('public/client_uploads/items/'.$item['image']) }}">
                                                </div>
                                            @endif

                                            {{-- Name Section --}}
                                            <h3>{{  (isset($item[$name_key]) && !empty($item[$name_key])) ? $item[$name_key] : $item['name'] }}</h3>

                                            {{-- New Product Image --}}
                                            @if($item['is_new'] == 1)
                                                <img class="is_new tag-img" src="{{ asset('public/client_images/bs-icon/new.png') }}">
                                            @endif

                                            {{-- Signature Image --}}
                                            @if($item['as_sign'] == 1)
                                                <img class="is_sign tag-img" src="{{ asset('public/client_images/bs-icon/signature.png') }}">
                                            @endif

                                            {{-- Day Special Image --}}
                                            @if($item['day_special'] == 1)
                                                <img class="is_special tag-img" src="{{ asset('public/client_images/bs-icon/special.png') }}">
                                            @endif

                                            {{-- Ingredient Section --}}
                                            @php
                                                $ingrediet_arr = (isset($item['ingredients']) && !empty($item['ingredients'])) ? unserialize($item['ingredients']) : [];
                                            @endphp

                                            @if(count($ingrediet_arr) > 0)
                                                <div>
                                                    @foreach ($ingrediet_arr as $val)
                                                        @php
                                                            $ingredient = getIngredientDetail($val);
                                                            $ing_icon = isset($ingredient['icon']) ? $ingredient['icon'] : '';
                                                        @endphp

                                                        @if(!empty($ing_icon) && file_exists('public/admin_uploads/ingredients/'.$ing_icon))
                                                            <img src="{{ asset('public/admin_uploads/ingredients/'.$ing_icon) }}" width="20px">
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif

                                            {{-- Description Section --}}
                                            <p>{{ (isset($item[$description_key]) && !empty($item[$description_key])) ? $item[$description_key] : $item['description'] }}</p>

                                            {{-- Price Section --}}
                                            <ul class="price_ul">
                                                @php
                                                    $price_arr = (isset($item[$price_key]) && !empty($item[$price_key])) ? unserialize($item[$price_key]) : [];
                                                    $price = isset($price_arr['price']) ? $price_arr['price'] : [];
                                                    $label = isset($price_arr['label']) ? $price_arr['label'] : [];
                                                @endphp

                                                @if(count($price) > 0)
                                                    @foreach ($price as $key => $value)
                                                        <li>
                                                            <p>{{ isset($label[$key]) ? $label[$key] : '' }} : <span>{{ $value }}</span></p>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    @endforeach
                                @else
                                    <h3>Items Not Found !</h3>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
		</div>
	</div>
	</section>

	<a class="back_bt" href="{{ route('restaurant',$shop_details['id']) }}"><i class="fa-solid fa-chevron-left"></i></a>

@endsection


{{-- Page JS Function --}}
@section('page-js')
@endsection
