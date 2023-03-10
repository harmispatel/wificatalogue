@extends('admin.layouts.admin-layout')

@section('title', 'Settings')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Settings</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Sttings Section --}}
    <section class="section dashboard">
        <div class="row">
            {{-- Error Message Section --}}
            @if (session()->has('error'))
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            {{-- Success Message Section --}}
            @if (session()->has('success'))
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            {{-- Settings Card --}}
            <div class="col-md-12">
                <div class="card">
                    <form class="form" action="{{ route('update.admin.settings') }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf

                            {{-- Fav Clients Limit --}}
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <b>Favourites Clients Limit</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="favourite_client_limit" class="form-control {{ ($errors->has('favourite_client_limit')) ? 'is-invalid' : '' }}" value="{{ isset($settings['favourite_client_limit']) ? $settings['favourite_client_limit'] : '' }}">
                                    @if($errors->has('favourite_client_limit'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('favourite_client_limit') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- CopyRight Text --}}
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <b>Copyright</b>
                                </div>
                                <div class="col-md-6">
                                    <textarea name="copyright_text" id="copyright_text" rows="5" class="form-control {{ ($errors->has('copyright_text')) ? 'is-invalid' : '' }}">{{ isset($settings['copyright_text']) ? $settings['copyright_text'] : '' }}</textarea>
                                    @if($errors->has('copyright_text'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('copyright_text') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Logo --}}
                            @php
                                $logo = isset($settings['logo']) ? $settings['logo'] : '';
                            @endphp
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <b>Logo</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="logo" class="form-control {{ ($errors->has('logo')) ? 'is-invalid' : '' }}">
                                    <code>Max Dimensions of Logo (150*50)</code>
                                     @if($errors->has('logo'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('logo') }}
                                        </div>
                                    @endif
                                    @if(!empty($logo))
                                        <div class="mt-3">
                                            <img src="{{ $logo }}" alt="" width="150">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @php
                                $login_bg = isset($settings['login_form_background']) ? $settings['login_form_background'] : '';
                            @endphp
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <b>Login Form Background</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="login_form_background" class="form-control {{ ($errors->has('login_form_background')) ? 'is-invalid' : '' }}">
                                    @if($errors->has('login_form_background'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('login_form_background') }}
                                        </div>
                                    @endif
                                    @if(!empty($login_bg))
                                        <div class="mt-3">
                                            <img src="{{ $login_bg }}" alt="" width="100">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Default Light Theme Image --}}
                            @php
                                $light_img = isset($settings['default_light_theme_image']) ? $settings['default_light_theme_image'] : '';
                            @endphp
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <b>Default Light Theme Image</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="default_light_theme_image" id="default_light_theme_image" class="form-control {{ ($errors->has('default_light_theme_image')) ? 'is-invalid' : '' }}">
                                    @if($errors->has('default_light_theme_image'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('default_light_theme_image') }}
                                        </div>
                                    @endif
                                    @if(!empty($light_img))
                                        <div class="mt-3">
                                            <img src="{{ $light_img }}" alt="" width="100">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Default Dark Theme Image --}}
                            @php
                                $dark_img = isset($settings['default_dark_theme_image']) ? $settings['default_dark_theme_image'] : '';
                            @endphp
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <b>Default Dark Theme Image</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="default_dark_theme_image" id="default_dark_theme_image" class="form-control {{ ($errors->has('default_dark_theme_image')) ? 'is-invalid' : '' }}">
                                    @if($errors->has('default_dark_theme_image'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('default_dark_theme_image') }}
                                        </div>
                                    @endif
                                    @if(!empty($dark_img))
                                        <div class="mt-3">
                                            <img src="{{ $dark_img }}" alt="" width="100">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Theme Main Screen Demo --}}
                            @php
                                $theme_main_screen = isset($settings['theme_main_screen_demo']) ? $settings['theme_main_screen_demo'] : '';
                            @endphp
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <b>Theme Main Screen Demo</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="theme_main_screen_demo" id="theme_main_screen_demo" class="form-control {{ ($errors->has('theme_main_screen_demo')) ? 'is-invalid' : '' }}">
                                    @if($errors->has('theme_main_screen_demo'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('theme_main_screen_demo') }}
                                        </div>
                                    @endif
                                    @if(!empty($theme_main_screen))
                                        <div class="mt-3">
                                            <img src="{{ $theme_main_screen }}" alt="" width="100">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Theme Category Screen Demo --}}
                            @php
                                $theme_category_screen = isset($settings['theme_category_screen_demo']) ? $settings['theme_category_screen_demo'] : '';
                            @endphp
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <b>Theme Category Screen Demo</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="theme_category_screen_demo" id="theme_category_screen_demo" class="form-control {{ ($errors->has('theme_category_screen_demo')) ? 'is-invalid' : '' }}">
                                    @if($errors->has('theme_category_screen_demo'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('theme_category_screen_demo') }}
                                        </div>
                                    @endif
                                    @if(!empty($theme_category_screen))
                                        <div class="mt-3">
                                            <img src="{{ $theme_category_screen }}" alt="" width="100">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Default Special Item Image --}}
                            @php
                                $default_special_item_image = isset($settings['default_special_item_image']) ? $settings['default_special_item_image'] : '';
                            @endphp
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <b>Default Spcial Item Image</b>
                                </div>
                                <div class="col-md-6">
                                    <input type="file" name="default_special_item_image" id="default_special_item_image" class="form-control {{ ($errors->has('default_special_item_image')) ? 'is-invalid' : '' }}">
                                    @if($errors->has('default_special_item_image'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('default_special_item_image') }}
                                        </div>
                                    @endif
                                    @if(!empty($default_special_item_image))
                                        <div class="mt-3">
                                            <img src="{{ $default_special_item_image }}" alt="" width="100">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- New Language Section --}}
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <b>New Language</b>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="lang_name" id="lang_name" class="form-control" placeholder="Enter Language Name">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="lang_code" id="lang_code" class="form-control" placeholder="Enter Language Code">
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-success" onclick="addNewLanguage()"><i class="bi bi-save"></i></a>
                                </div>
                            </div>


                            {{-- Languages Section --}}
                            @php
                                $languages_array = [];
                                foreach ($languages as $key => $value) {
                                    $languages_array[] = $value->id;
                                }
                            @endphp
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <b>Languages</b>
                                </div>
                                <div class="col-md-6">
                                    <select name="languages[]" id="languages" class="form-control {{ ($errors->has('languages')) ? 'is-invalid' : '' }}" multiple>
                                        @if(count($languages) > 0)
                                            @foreach ($languages as $language)
                                                <option value="{{ $language->id }}" {{ (in_array($language->id,$languages_array)) ? 'selected' : '' }}>{{ $language->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if($errors->has('languages'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('languages') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

{{-- Custom JS --}}
@section('page-js')
    <script type="text/javascript">

        // Select 2
        $("#languages").select2();

        // Add New Language
        function addNewLanguage(){
            var lang_name = $('#lang_name').val();
            var lang_code = $('#lang_code').val();

            if(lang_name == '' && lang_code == '')
            {
                alert('Please Enter Language Name or Code!');
                return false;
            }
            else
            {
                $.ajax({
                    type: "POST",
                    url: "{{ route('languages.save.ajax') }}",
                    data: {
                        "_token" : "{{ csrf_token() }}",
                        "name" : lang_name,
                        "code" : lang_code,
                    },
                    dataType: "JSON",
                    success: function (response) {
                        if(response.success == 1)
                        {
                            toastr.success("Language has been Inseted SuccessFully...");
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    }
                });
            }

        }

    </script>
@endsection
