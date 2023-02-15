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
                                    <input type="text" name="copyright_text" class="form-control {{ ($errors->has('copyright_text')) ? 'is-invalid' : '' }}" value="{{ isset($settings['copyright_text']) ? $settings['copyright_text'] : '' }}">
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
                                     @if($errors->has('logo'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('logo') }}
                                        </div>
                                    @endif
                                    @if(!empty($logo))
                                        <div class="mt-3">
                                            <img src="{{ $logo }}" alt="" width="100">
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

    </script>
@endsection
