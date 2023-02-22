@extends('client.layouts.client-layout')

@section('title', 'Theme-Preview')

@section('content')

    <section class="theme_section">
        <div class="main_section_inr">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Design Settings</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Default light theme</li>
                </ol>
            </nav>
            <div class="row">
                <div class="col-md-12">
                    <div class="theme_change_sec">
                        <div class="theme_name">
                            <h2>Default light theme</h2>
                        </div>
                        <div class="theme_change_sec_inr">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Main Screen
                                          </button>
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
                                                                    <input type="color" id="favcolor" name="favcolor" class="form-control me-2 p-0" value="#ff0000">
                                                                    <input type="text" class="form-control" placeholder="#ff0000">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-7">
                                                                <span>Background Color</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="favcolor" name="favcolor" class="form-control me-2 p-0" value="#ff0000">
                                                                    <input type="text" class="form-control" placeholder="#ff0000">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-7">
                                                                <span>Font colour</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="favcolor" name="favcolor" class="form-control me-2 p-0" value="#ff0000">
                                                                    <input type="text" class="form-control" placeholder="#ff0000">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-7">
                                                                <span>Label colour</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="favcolor" name="favcolor" class="form-control me-2 p-0" value="#ff0000">
                                                                    <input type="text" class="form-control" placeholder="#ff0000">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-7">
                                                                <span>Social media icons colour</span>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="favcolor" name="favcolor" class="form-control me-2 p-0" value="#ff0000">
                                                                    <input type="text" class="form-control" placeholder="#ff0000">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="preview_img">
                                                        <img src="{{ asset('public/client_images/not-found/theme_main_screen.png') }}" class="w-100">
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                    </div>
                                </div>
                                 <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Within category screen
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="main_theme_color">
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Categories bar colour</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="favcolor" name="favcolor" class="form-control me-2 p-0" value="#ff0000">
                                                                    <input type="text" class="form-control" placeholder="#ff0000">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Menu bar font colour</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="favcolor" name="favcolor" class="form-control me-2 p-0" value="#ff0000">
                                                                    <input type="text" class="form-control" placeholder="#ff0000">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Category title & description font colour</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="favcolor" name="favcolor" class="form-control me-2 p-0" value="#ff0000">
                                                                    <input type="text" class="form-control" placeholder="#ff0000">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Price colour</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="favcolor" name="favcolor" class="form-control me-2 p-0" value="#ff0000">
                                                                    <input type="text" class="form-control" placeholder="#ff0000">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Item divider</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="favcolor" name="favcolor" class="form-control me-2 p-0" value="#ff0000">
                                                                    <input type="text" class="form-control" placeholder="#ff0000">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Divider colour</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="favcolor" name="favcolor" class="form-control me-2 p-0" value="#ff0000">
                                                                    <input type="text" class="form-control" placeholder="#ff0000">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Divider thickness</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="favcolor" name="favcolor" class="form-control me-2 p-0" value="#ff0000">
                                                                    <input type="text" class="form-control" placeholder="#ff0000">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Tag Font Color</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="favcolor" name="favcolor" class="form-control me-2 p-0" value="#ff0000">
                                                                    <input type="text" class="form-control" placeholder="#ff0000">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Tag Label Color</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="favcolor" name="favcolor" class="form-control me-2 p-0" value="#ff0000">
                                                                    <input type="text" class="form-control" placeholder="#ff0000">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row align-items-center mb-4">
                                                            <div class="col-md-8">
                                                                <span>Item Divider Font Color</span>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="from-group d-flex align-items-center">
                                                                    <input type="color" id="favcolor" name="favcolor" class="form-control me-2 p-0" value="#ff0000">
                                                                    <input type="text" class="form-control" placeholder="#ff0000">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="preview_img">
                                                        <img src="{{ asset('public/client_images/not-found/theme_within_category_screen.png') }}" class="w-100">
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

            </div>
        </div>
    </section>


@endsection

{{-- Custom JS --}}
{{-- @section('page-js')

    <script type="text/javascript">
        $("input[type='image']").click(function() {
            $("input[id='my_file']").click();
        });

    </script>

@endsection --}}
