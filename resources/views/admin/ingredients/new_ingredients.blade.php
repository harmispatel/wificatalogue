@extends('admin.layouts.admin-layout')

@section('title', 'New Indicative Icons')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ __('Indicative Icons')}}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('ingredients') }}">{{ __('Indicative Icons')}}</a></li>
                        <li class="breadcrumb-item active">{{ __('New Indicative Icons')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a href="{{ route('ingredients') }}" class="btn btn-sm new-amenity btn-primary">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- New Ingredient add Section --}}
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

            {{-- Ingredients Card --}}
            <div class="col-md-12">
                <div class="card">
                    <form class="form" action="{{ route('ingredients.store') }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="card-title">
                            </div>
                            @csrf
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="name" class="form-label">{{ __('Name')}}</label>
                                            <input type="text" name="name" id="name" class="form-control {{ ($errors->has('name')) ? 'is-invalid' : '' }}" placeholder="Enter Ingredient Name" value="{{ old('name') }}">
                                            @if($errors->has('name'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="icon" class="form-label">{{ __('Icon')}}</label>
                                            <input type="file" name="icon" id="icon" class="form-control {{ ($errors->has('icon')) ? 'is-invalid' : '' }}">
                                            @if($errors->has('icon'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('icon') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group mt-2">
                                            <code>Valid Dimensions of Icon is (40*40)</code>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="status" class="form-label">{{ __('Status')}}</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="status" role="switch" id="status" value="1" checked>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-success">{{ __('Save')}}</button>
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
