@php
    $client_settings = getClientSettings();
@endphp

@extends('client.layouts.client-layout')

@section('title', 'General Info')

@section('content')

    <section class="general_info_main">
        <div class="sec_title">
            <h2>General Information</h2>
        </div>
        <div class="site_info">
            <form id="generalInfo" action="{{ route('design.generalInfoUpdate') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="business_name">Business name</label>
                            <div class="input-group">
                                <input type="text" class="form-control {{ ($errors->has('business_name')) ? 'is-invalid' : '' }}" name="business_name" id="business_name" value="{{ (isset($client_settings['business_name']) && !empty($client_settings['business_name'])) ? $client_settings['business_name'] : '' }}">
                                <span class="input-group-text">#475</span>
                                @if($errors->has('business_name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('business_name') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="default_currency">Currency</label>
                            <select  class="form-select {{ ($errors->has('default_currency')) ? 'is-invalid' : '' }}" name="default_currency" id="default_currency">
                                <option value="">Choose Currency</option>
                                <option value="1" {{ (isset($client_settings['default_currency']) && ($client_settings['default_currency'] == 1)) ? 'selected' : '' }}>EUR</option>
                                <option value="2" {{ (isset($client_settings['default_currency']) && ($client_settings['default_currency'] == 2)) ? 'selected' : '' }}>USD</option>
                                <option value="3" {{ (isset($client_settings['default_currency']) && ($client_settings['default_currency'] == 3)) ? 'selected' : '' }}>GBP</option>
                            </select>
                            @if($errors->has('default_currency'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('default_currency') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label" for="business_telephone">Telephone</label>
                            <div class="position-relative">
                                <input type="text" class="form-control icon-input" name="business_telephone" id="business_telephone" value="{{ (isset($client_settings['business_telephone']) && !empty($client_settings['business_telephone'])) ? $client_settings['business_telephone'] : '' }}">
                                <i class="fa-solid fa-phone input-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="social_media_part">
                    <div class="social_media_title">
                        <h2>Social Plateforms</h2>
                        <p>Fill in your digital assets and they will appear at the bottom of your menu. Boost your online community!</p>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="instagram_link">Instagram</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control icon-input" id="instagram_link" name="instagram_link" value="{{ (isset($client_settings['instagram_link']) && !empty($client_settings['instagram_link'])) ? $client_settings['instagram_link'] : '' }}">
                                    <i class="fa-brands fa-instagram input-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="twitter_link">Twitter</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control icon-input" name="twitter_link" id="twitter_link" value="{{ (isset($client_settings['twitter_link']) && !empty($client_settings['twitter_link'])) ? $client_settings['twitter_link'] : '' }}">
                                    <i class="fa-brands fa-twitter input-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="facebook_link">Facebook</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control icon-input" name="facebook_link" id="facebook_link" value="{{ (isset($client_settings['facebook_link']) && !empty($client_settings['facebook_link'])) ? $client_settings['facebook_link'] : '' }}">
                                    <i class="fa-brands fa-facebook-f input-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="foursquare_link">Foursquare</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control icon-input" name="foursquare_link" id="foursquare_link" value="{{ (isset($client_settings['foursquare_link']) && !empty($client_settings['foursquare_link'])) ? $client_settings['foursquare_link'] : '' }}">
                                    <i class="fa-brands fa-foursquare input-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="tripadvisor_link">Tripadvisor</label>
                                <div class="position-relative">
                                    <input type="text" class="form-control icon-input" name="tripadvisor_link" id="tripadvisor_link" value="{{ (isset($client_settings['tripadvisor_link']) && !empty($client_settings['tripadvisor_link'])) ? $client_settings['tripadvisor_link'] : '' }}">
                                    <i class="fa-solid fa-mask input-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label" for="homepage_intro">Homepage Intro</label>
                            {{-- please text editor use --}}
                            <textarea class="form-control" placeholder="Write Your Shop Intro Here." id="homepage_intro" name="homepage_intro">{{ (isset($client_settings['homepage_intro']) && !empty($client_settings['homepage_intro'])) ? $client_settings['homepage_intro'] : '' }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="map_url">Map</label>
                            <div class="position-relative">
                                <input type="text" class="form-control icon-input" name="map_url" id="map_url" value="{{ (isset($client_settings['map_url']) && !empty($client_settings['map_url'])) ? $client_settings['map_url'] : '' }}">
                                <i class="fa-solid fa-map input-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="website_url">Website</label>
                            <div class="position-relative">
                                <input type="text" class="form-control icon-input" name="website_url" id="website_url" value="{{ (isset($client_settings['website_url']) && !empty($client_settings['website_url'])) ? $client_settings['website_url'] : '' }}">
                                <i class="fa-solid fa-globe input-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <button class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection


{{-- Custom JS --}}
@section('page-js')

    <script type="text/javascript">

        // Toastr Settings
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            timeOut: 4000
        }

        // Success Message
        @if (Session::has('success'))
            toastr.success('{{ Session::get('success') }}')
        @endif

    </script>

@endsection

