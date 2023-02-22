@extends('client.layouts.client-layout')

@section('title', 'Cover')

@section('content')

    <section class="logo_sec">
        <div class="row">
            <div class="col-md-12">
                <div class="add_logo_sec">
                    <div class="add_logo_sec_header">
                        <h2>Logo</h2>
                    </div>
                    <div class="add_logo_sec_body">
                        <p>Logo will appear on the top of your menu</p>
                        <div class="add_logo_sec_body_inr">
                            <input type="image" src="{{ asset('public/client_images/not-found/no_image_1.jpg') }}" width="200px"/>
                            <input type="file" id="my_file" style="display: none;" />
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="add_logo_sec">
                    <div class="add_logo_sec_header">
                        <h2>Logo</h2>
                    </div>
                    <div class="add_logo_sec_body">
                        <p>Intro image will appear before your digital menu for the duration specified image Specs : File size <2MB, Recommended image size : 1920x1080 pixels.</p>
                        <div class="add_logo_sec_body_inr">
                            <div>
                                <input type="image" src="{{ asset('public/client_images/not-found/no_image_1.jpg') }}" width="200px"/>
                                <input type="file" id="my_file" style="display: none;" />
                                <div class="form-group mt-2">
                                    <label class="form-label">Intro duration in seconds</label>
                                    <input type="number" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>

@endsection

{{-- Custom JS --}}
@section('page-js')

    <script type="text/javascript">
        $("input[type='image']").click(function() {
            $("input[id='my_file']").click();
        });

    </script>

@endsection
