@extends('client.layouts.client-layout')

@section('title', 'General Info')

@section('content')

    <section class="general_info_main">
        <div class="sec_title">
            <h2>General Information</h2>
        </div>
        <div class="site_info">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Business name</label>
                        <div class="input-group">
                            <input type="text" class="form-control">
                            <span class="input-group-text">#475</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Select currency</label>
                        <select  class="form-select form-control">
                            <option value="EUR">EUR</option>
                            <option value="USD">USD</option>
                            <option value="GBP">GBP</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label">Telephone</label>
                        <div class="position-relative">
                            <input type="text" class="form-control icon-input">
                            <i class="fa-solid fa-phone input-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="social_media_part">
                <div class="social_media_title">
                    <h2>Social platforms</h2>
                    <p>Fill in your digital assets and they will appear at the bottom of your menu. Boost your online community!</p>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Instagram</label>
                            <div class="position-relative">
                                <input type="text" class="form-control icon-input">
                                <i class="fa-brands fa-instagram input-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Twitter</label>
                            <div class="position-relative">
                                <input type="text" class="form-control icon-input">
                                <i class="fa-brands fa-twitter input-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Facebook</label>
                            <div class="position-relative">
                                <input type="text" class="form-control icon-input">
                                <i class="fa-brands fa-facebook-f input-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Foursquare</label>
                            <div class="position-relative">
                                <input type="text" class="form-control icon-input">
                                <i class="fa-brands fa-foursquare input-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label class="form-label">Tripadvisor</label>
                            <div class="position-relative">
                                <input type="text" class="form-control icon-input">
                                <i class="fa-solid fa-mask input-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Homepage Intro</label>
                        {{-- please text editor use --}}
                        <textarea class="form-control" placeholder="message" id="floatingTextarea"></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Map</label>
                        <div class="position-relative">
                            <input type="text" class="form-control icon-input">
                            <i class="fa-solid fa-map input-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Website</label>
                        <div class="position-relative">
                            <input type="text" class="form-control icon-input">
                            <i class="fa-solid fa-globe input-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


