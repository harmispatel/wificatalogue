@extends('client.layouts.client-layout')

@section('title', 'Qr-Code')

@section('content')

    <section class="qr_main">
        <div class="sec_title">
            <h2>Qr Code</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="qr_img">
                    <img src="{{ asset('public/client_images/not-found/qr_img.png') }}" class="w-100" >
                    <div class="qr_btn_group d-flex align-center justify-content-center mt-4">
                        <button class="btn qr_btn btn-primary me-3">Download</button>
                        <button class="btn qr_btn btn-primary">Print</button>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-3">
                        <div class="qr_sidebar">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link active text-start" id="v-pills-Image-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Image" type="button" role="tab" aria-controls="v-pills-Image" aria-selected="true">Image</button>
                                <button class="nav-link text-start" id="v-pills-Color-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Color" type="button" role="tab" aria-controls="v-pills-Color" aria-selected="false">Color</button>
                                <button class="nav-link text-start" id="v-pills-Style-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Style" type="button" role="tab" aria-controls="v-pills-Style" aria-selected="false">Style</button>
                                <button class="nav-link text-start" id="v-pills-Size-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Size" type="button" role="tab" aria-controls="v-pills-Size" aria-selected="false">Size</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="qr_content">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-Image" role="tabpanel" aria-labelledby="v-pills-Image-tab">
                                    <div class="form-group">
                                        <input class="form-control mb-3" type="file" id="formFile">
                                        <button class="btn btn-outline-danger remove_bt">Remove Image</button>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-Color" role="tabpanel" aria-labelledby="v-pills-Color-tab">
                                    <div class="qr_color_content">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Select Color Type</label>
                                                <select class="form-select form-control">
                                                    <option value="">Only Single Color</option>
                                                    <option value="vertical"> Vertical</option>
                                                    <option value="horizontal"> Horizontal</option>
                                                    <option value="diagonal"> Diagonal</option>
                                                    <option value="inverse_diagonal"> Inverse Diagonal</option>
                                                    <option value="radial"> Radial</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="form-label">Select Color</label>
                                                    <input type="color" class="form-control form-control-color" value="#000000" title="Choose your color">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="form-label">Select Color</label>
                                                    <input type="range" value="100" class="form-range">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="form-label">Select Background Color</label>
                                                    <input type="color" class="form-control form-control-color" value="#ffffff" title="Choose your color">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="form-label">Background Color Transparent</label>
                                                    <input type="range" value="100" class="form-range">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-Style" role="tabpanel" aria-labelledby="v-pills-Style-tab">
                                    <div class="qr_color_content">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Select Color Type</label>
                                                <select  class="form-select form-control">
                                                    <option value="square"> Square</option>
                                                    <option value="dot"> Dot</option>
                                                    <option value="round"> Round</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Select Eye Style</label>
                                                <select class="form-select form-control">
                                                    <option value="square"> Square</option>
                                                    <option value="circle"> Circle</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="form-label">Select Eye Inner Color</label>
                                                    <input type="color" class="form-control form-control-color" value="#000000" title="Choose your color">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label class="form-label">Select Eye Outer Color</label>
                                                    <input type="color" class="form-control form-control-color" value="#000000" title="Choose your color">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-Size" role="tabpanel" aria-labelledby="v-pills-Size-tab">
                                    <div class="qr_color_content">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <div class="form-group">
                                                    <label class="form-label">QR Size</label>
                                                    <input type="range" value="100" class="form-range">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="qr_sidebar_btn_group mt-4 d-flex align-items-center">
                    <button class="btn btn-primary me-3">Save</button>
                    <button class="btn btn btn-outline-danger ">Save</button>
                </div>
            </div>
        </div>
    </section>

@endsection

{{-- Custom JS --}}

