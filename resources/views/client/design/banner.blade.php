@extends('client.layouts.client-layout')

@section('title', 'Banner')

@section('content')

    <section class="logo_sec">
        <div class="row">
            <div class="col-md-12">
                <div class="add_logo_sec">
                    <div class="add_logo_sec_header">
                        <h2>Banner</h2>
                    </div>

                    @php
                        $primary_code = isset($primary_language_detail['code']) ? $primary_language_detail['code'] : '';
                        $primary_name = isset($primary_language_detail['name']) ? $primary_language_detail['name'] : '';

                        $primary_banner_id = $primary_code."_banner_img";
                        $primary_form_id = $primary_code."_banner_form";

                        $primary_title_key = $primary_code."_title";
                        $primary_banner_key = $primary_code."_image";

                        $primary_banner_text = isset($banner_setting[$primary_title_key]) ? $banner_setting[$primary_title_key] : '';

                        $primary_banner_image = isset($banner_setting[$primary_banner_key]) ? $banner_setting[$primary_banner_key] : '';
                    @endphp

                    @if(count($additional_languages) > 0)
                        <div class="add_logo_sec_body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">

                                {{-- For Primary Language --}}
                                <li class="nav-item" role="presentation">
                                    <button title="{{ $primary_name }}" class="nav-link active" id="{{ $primary_code }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $primary_code }}" type="button" role="tab" aria-controls="{{ $primary_code }}" aria-selected="true">{{ strtoupper($primary_code) }}</button>
                                </li>

                                {{-- For Additional Language --}}
                                @foreach ($additional_languages as $value)
                                    @php
                                        // Additional Language Details
                                        $add_lang_detail = App\Models\Languages::where('id',$value->language_id)->first();
                                        $add_lang_code = isset($add_lang_detail->code) ? $add_lang_detail->code : '';
                                        $add_lang_name = isset($add_lang_detail->name) ? $add_lang_detail->name : '';
                                    @endphp

                                    <li class="nav-item" role="presentation">
                                        <button title="{{ $add_lang_name }}" data-bs-toggle="tab"  class="nav-link" id="{{ $add_lang_code }}-tab" data-bs-target="#{{ $add_lang_code }}" type="butto
                                        " role="tab" aria-controls="{{ $add_lang_code }}" aria-selected="false">{{ strtoupper($add_lang_code) }}</button>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-content" id="myTabContent">

                                {{-- Primary Tab --}}
                                <div class="tab-pane fade show active mt-3" id="{{ $primary_code }}" role="tabpanel" aria-labelledby="{{ $primary_code }}-tab">
                                    <form method="POST" id="{{ $primary_form_id }}" action="{{ route('design.banner.update') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="shop_id" id="shop_id" value="{{ $shop_id }}">
                                        <input type="hidden" name="lang_code" id="lang_code" value="{{ $primary_code }}">

                                        <div class="add_logo_sec_body">
                                            <label class="form-label">Banner will appear on the top of your menu</label>
                                            <div class="add_logo_sec_body_inr">
                                                <label for="{{ $primary_banner_id }}" style="cursor: pointer;">
                                                    @if(!empty($primary_banner_image) && file_exists('public/client_uploads/banners/'.$primary_banner_image))
                                                        <img src="{{ asset('public/client_uploads/banners/'.$primary_banner_image) }}" width="200px">
                                                    @else
                                                        <img src="{{ asset('public/client_images/not-found/no_image_1.jpg') }}" width="200px"/>
                                                    @endif
                                                </label>
                                                <input type="file" name="banner" onchange="uploadImage('{{ $primary_form_id }}')" id="{{ $primary_banner_id }}" style="display: none;" />
                                            </div>
                                        </div>

                                        <div class="banner_text">
                                            <label class="form-label">Banner Text</label>
                                            <textarea class="form-control" name="banner_text" id="banner_text">{{ $primary_banner_text }}</textarea>
                                        </div>

                                        <div class="add_logo_sec_body">
                                            <button class="btn btn-success">Update</button>
                                        </div>
                                    </form>
                                </div>

                                {{-- Additional Tabs --}}
                                @foreach($additional_languages as $value)
                                    @php
                                        // Additional Language Details
                                        $add_lang_detail = App\Models\Languages::where('id',$value->language_id)->first();
                                        $add_lang_code = isset($add_lang_detail->code) ? $add_lang_detail->code : '';
                                        $add_lang_name = isset($add_lang_detail->name) ? $add_lang_detail->name : '';
                                        $add_input_lang_code = "'$add_lang_code'";

                                        $add_banner_id = $add_lang_code."_banner_img";
                                        $add_form_id = $add_lang_code."_banner_form";

                                        $add_title_key = $add_lang_code."_title";
                                        $add_banner_key = $add_lang_code."_image";

                                        $add_banner_text = isset($banner_setting[$add_title_key]) ? $banner_setting[$add_title_key] : '';

                                        $add_banner_image = isset($banner_setting[$add_banner_key]) ? $banner_setting[$add_banner_key] : '';

                                    @endphp

                                    <div class="tab-pane fade show mt-3" id="{{ $add_lang_code }}" role="tabpanel" aria-labelledby="{{ $add_lang_code }}-tab">
                                        <form method="POST" id="{{ $add_form_id }}" action="{{ route('design.banner.update') }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="shop_id" id="shop_id" value="{{ $shop_id }}">
                                            <input type="hidden" name="lang_code" id="lang_code" value="{{ $add_lang_code }}">

                                            <div class="add_logo_sec_body">
                                                <label class="form-label">Banner will appear on the top of your menu</label>
                                                <div class="add_logo_sec_body_inr">
                                                    <label for="{{ $add_banner_id }}" style="cursor: pointer;">
                                                        @if(!empty($add_banner_image) && file_exists('public/client_uploads/banners/'.$add_banner_image))
                                                            <img src="{{ asset('public/client_uploads/banners/'.$add_banner_image) }}" width="200px">
                                                        @else
                                                            <img src="{{ asset('public/client_images/not-found/no_image_1.jpg') }}" width="200px"/>
                                                        @endif
                                                    </label>
                                                    <input type="file" name="banner" onchange="uploadImage('{{ $add_form_id }}')" id="{{ $add_banner_id }}" style="display: none;" />
                                                </div>
                                            </div>

                                            <div class="banner_text">
                                                <label class="form-label">Banner Text</label>
                                                <textarea class="form-control" name="banner_text" id="banner_text">{{ $add_banner_text }}</textarea>
                                            </div>

                                            <div class="add_logo_sec_body">
                                                <button class="btn btn-success">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else

                        <form method="POST" id="{{ $primary_form_id }}" action="{{ route('design.banner.update') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="shop_id" id="shop_id" value="{{ $shop_id }}">
                            <input type="hidden" name="lang_code" id="lang_code" value="{{ $primary_code }}">

                            <div class="add_logo_sec_body">
                                <label class="form-label">Banner will appear on the top of your menu</label>
                                <div class="add_logo_sec_body_inr">
                                    <label for="{{ $primary_banner_id }}" style="cursor: pointer;">
                                        @if(!empty($primary_banner_image) && file_exists('public/client_uploads/banners/'.$primary_banner_image))
                                            <img src="{{ asset('public/client_uploads/banners/'.$primary_banner_image) }}" width="200px">
                                        @else
                                            <img src="{{ asset('public/client_images/not-found/no_image_1.jpg') }}" width="200px"/>
                                        @endif
                                    </label>
                                    <input type="file" name="banner" onchange="uploadImage('{{ $primary_form_id }}')" id="{{ $primary_banner_id }}" style="display: none;" />
                                </div>
                            </div>

                            <div class="banner_text">
                                <label class="form-label">Banner Text</label>
                                <textarea class="form-control" name="banner_text" id="banner_text">{{ $primary_banner_text }}</textarea>
                            </div>

                            <div class="add_logo_sec_body">
                                <button class="btn btn-success">Update</button>
                            </div>

                        </form>
                    @endif
                    {{-- <div class="banner_text">
                        <label class="form-label">Banner Text</label>
                        <textarea name="" id="" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="add_logo_sec_body">
                        <label class="form-label">Banner will appear on the top of your menu</label>
                        <div class="add_logo_sec_body_inr">
                            <input type="image" src="{{ asset('public/client_images/not-found/no_image_1.jpg') }}" width="200px"/>
                            <input type="file" id="my_file" style="display: none;" />
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>

@endsection

{{-- Custom JS --}}
@section('page-js')

    <script type="text/javascript">

        $(document).ready(function()
        {
            @if (Session::has('success'))
                toastr.success('{{ Session::get('success') }}')
            @endif
        });

        // Submit Form After Select Image
        function uploadImage(formID)
        {
            $('#'+formID).submit();
        }

    </script>

@endsection
