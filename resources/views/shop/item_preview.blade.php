@php
    // Shop Settings
    $shop_settings = getClientSettings($shop_details['id']);

    // Shop Currency
    $currency = (isset($shop_settings['default_currency']) && !empty($shop_settings['default_currency'])) ? $shop_settings['default_currency'] : 'EUR';

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
			<ul class="nav nav-tabs" id="myTab" role="tablist">

                @if(count($categories) > 0)
                    @foreach ($categories as $cat)
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('items.preview',[$shop_details['shop_slug'],$cat->id]) }}" class="nav-link cat-btn {{ ($cat->id == $current_cat_id) ? 'active' : '' }}">
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
                    <h3 class="mb-3 cat_name">{{ isset($cat_details[$name_key]) ? $cat_details[$name_key] : $cat_details['name'] }}</h3>

                    <div class="item_inr_info">

                        @if(count($cat_tags) > 0)
                            {{-- Tags Section --}}
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active tags-btn" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">All</button>
                                </li>

                                @foreach ($cat_tags as $tag)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link text-capitalize tags-btn" id="{{ $tag['id'] }}-tab" data-bs-toggle="tab" data-bs-target="#tag{{ $tag['id'] }}" type="button" role="tab" aria-controls="tag{{ $tag['id'] }}" aria-selected="false">{{ (isset($tag[$name_key])) ? $tag[$name_key] : $tag['name'] }}</button>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                                    <div class="item_inr_info_sec">
                                        <div class="row">
                                            @if(count($all_items) > 0)
                                                @foreach ($all_items as $item)
                                                    @if($item['type'] == 1)
                                                        <div class="col-md-3 mb-3">
                                                            <div class="single_item_inr devider-border">

                                                                {{-- Image Section --}}
                                                                @if(!empty($item['image']) && file_exists('public/client_uploads/items/'.$item['image']))
                                                                    <div class="item_image">
                                                                        <img src="{{ asset('public/client_uploads/items/'.$item['image']) }}">
                                                                    </div>
                                                                @endif

                                                                @if($item['day_special'] == 1)
                                                                    <img width="100" class="mt-3" src="{{ asset('public/client_images/bs-icon/today_special.gif') }}">
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
                                                                {{-- @if($item['day_special'] == 1)
                                                                    <img class="is_special tag-img" src="{{ asset('public/client_images/bs-icon/today_special.gif') }}">
                                                                @endif --}}

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
                                                                        $price_sec = (isset($item[$price_key]) && !empty($item[$price_key])) ? unserialize($item[$price_key]) : [];
                                                                        $price_arr = isset($price_sec['price']) ? $price_sec['price'] : [];
                                                                        $label = isset($price_sec['label']) ? $price_sec['label'] : [];
                                                                    @endphp

                                                                    @if(count($price_arr) > 0)
                                                                        @foreach ($price_arr as $key => $value)
                                                                            @php
                                                                                $price = Currency::currency($currency)->format($value);
                                                                            @endphp
                                                                            <li>
                                                                                <p>{{ isset($label[$key]) ? $label[$key] : '' }} : <span>{{ $price }}</span></p>
                                                                            </li>
                                                                        @endforeach
                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="col-md-12 mb-3">
                                                            <div class="single_item_inr devider">

                                                                {{-- Image Section --}}
                                                                @if(!empty($item['image']) && file_exists('public/client_uploads/items/'.$item['image']))
                                                                    <div class="item_image">
                                                                        <img src="{{ asset('public/client_uploads/items/'.$item['image']) }}">
                                                                    </div>
                                                                @endif

                                                                {{-- Name Section --}}
                                                                <h3>{{ (isset($item[$name_key]) && !empty($item[$name_key])) ? $item[$name_key] : $item['name'] }}</h3>


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

                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @foreach ($cat_tags as $tag)

                                    @php
                                        $tag_items = getTagsProducts($tag['tag_id'],$cat_details['id']);
                                    @endphp

                                    <div class="tab-pane fade show" id="tag{{ $tag['id'] }}" role="tabpanel" aria-labelledby="{{ $tag['id'] }}-tab">
                                        <div class="item_inr_info_sec">
                                            <div class="row">
                                                @if(count($tag_items) > 0)
                                                    @foreach ($tag_items as $item)
                                                        @if($item['type'] == 1)
                                                            <div class="col-md-3 mb-3">
                                                                <div class="single_item_inr devider-border">

                                                                    {{-- Image Section --}}
                                                                    @if(!empty($item->product['image']) && file_exists('public/client_uploads/items/'.$item->product['image']))
                                                                        <div class="item_image">
                                                                            <img src="{{ asset('public/client_uploads/items/'.$item->product['image']) }}">
                                                                        </div>
                                                                    @endif

                                                                    @if($item['day_special'] == 1)
                                                                        <img width="100" class="mt-3" src="{{ asset('public/client_images/bs-icon/today_special.gif') }}">
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
                                                                    {{-- @if($item->product['day_special'] == 1)
                                                                        <img class="is_special tag-img" src="{{ asset('public/client_images/bs-icon/special.png') }}">
                                                                    @endif --}}

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
                                                                            $price_sec = (isset($item->product[$price_key]) && !empty($item->product[$price_key])) ? unserialize($item->product[$price_key]) : [];
                                                                            $price_arr = isset($price_sec['price']) ? $price_sec['price'] : [];
                                                                            $label = isset($price_sec['label']) ? $price_sec['label'] : [];
                                                                        @endphp

                                                                        @if(count($price_arr) > 0)
                                                                            @foreach ($price_arr as $key => $value)
                                                                                @php
                                                                                    $price = Currency::currency($currency)->format($value);
                                                                                @endphp
                                                                                <li>
                                                                                    <p>{{ isset($label[$key]) ? $label[$key] : '' }} : <span>{{ $price }}</span></p>
                                                                                </li>
                                                                            @endforeach
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12 mb-3">
                                                                <div class="single_item_inr devider">

                                                                    {{-- Image Section --}}
                                                                    @if(!empty($item->product['image']) && file_exists('public/client_uploads/items/'.$item->product['image']))
                                                                        <div class="item_image">
                                                                            <img src="{{ asset('public/client_uploads/items/'.$item->product['image']) }}">
                                                                        </div>
                                                                    @endif

                                                                    {{-- Name Section --}}
                                                                    <h3>{{ (isset($item->product[$name_key]) && !empty($item->product[$name_key])) ? $item->product[$name_key] : $item->product['name'] }}</h3>

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

                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="item_inr_info_sec">
                                <div class="row">
                                    @if(count($all_items) > 0)
                                        @foreach ($all_items as $item)
                                            @if($item['type'] == 1)
                                                <div class="col-md-3 mb-3">
                                                    <div class="single_item_inr devider-border">

                                                        {{-- Image Section --}}
                                                        @if(!empty($item['image']) && file_exists('public/client_uploads/items/'.$item['image']))
                                                            <div class="item_image">
                                                                <img src="{{ asset('public/client_uploads/items/'.$item['image']) }}">
                                                            </div>
                                                        @endif

                                                        @if($item['day_special'] == 1)
                                                            <img width="100" class="mt-3" src="{{ asset('public/client_images/bs-icon/today_special.gif') }}">
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
                                                        {{-- @if($item['day_special'] == 1)
                                                            <img class="is_special tag-img" src="{{ asset('public/client_images/bs-icon/special.png') }}">
                                                        @endif --}}

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
                                                                $price_sec = (isset($item[$price_key]) && !empty($item[$price_key])) ? unserialize($item[$price_key]) : [];
                                                                $price_arr = isset($price_sec['price']) ? $price_sec['price'] : [];
                                                                $label = isset($price_sec['label']) ? $price_sec['label'] : [];
                                                            @endphp

                                                            @if(count($price_arr) > 0)
                                                                @foreach ($price_arr as $key => $value)
                                                                    @php
                                                                        $price = Currency::currency($currency)->format($value);
                                                                    @endphp
                                                                    <li>
                                                                        <p>{{ isset($label[$key]) ? $label[$key] : '' }} : <span>{{ $price }}</span></p>
                                                                    </li>
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-md-12 mb-3">
                                                    <div class="single_item_inr devider">

                                                        {{-- Image Section --}}
                                                        @if(!empty($item['image']) && file_exists('public/client_uploads/items/'.$item['image']))
                                                            <div class="item_image">
                                                                <img src="{{ asset('public/client_uploads/items/'.$item['image']) }}">
                                                            </div>
                                                        @endif

                                                        {{-- Name Section --}}
                                                        <h3>{{  (isset($item[$name_key]) && !empty($item[$name_key])) ? $item[$name_key] : $item['name'] }}</h3>

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
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @else
                                        <h3>Items Not Found !</h3>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
		</div>
	</div>
	</section>

	<a class="back_bt" href="{{ route('restaurant',$shop_details['shop_slug']) }}"><i class="fa-solid fa-chevron-left"></i></a>

@endsection


{{-- Page JS Function --}}
@section('page-js')
@endsection
