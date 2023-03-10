@extends('admin.layouts.admin-layout')

@section('title', __('Edit Subscription'))

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ __('Subscriptions')}}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('subscriptions') }}">{{ __('Subscriptions')}}</a></li>
                        <li class="breadcrumb-item active">{{ __('Edit Subscription')}}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a href="{{ route('subscriptions') }}" class="btn btn-sm new-amenity btn-primary">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Edit Subscription Section --}}
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

            {{-- Subscription Card --}}
            <div class="col-md-12">
                <div class="card">
                    <form class="form" action="{{ route('subscriptions.update') }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="card-title">
                            </div>
                            @csrf
                            <div class="container">
                                <div class="row">
                                    <input type="hidden" name="subscription_id" id="subscription_id" value="{{ $subscription->id }}">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="name" class="form-label">{{ __('Title')}}</label>
                                            <input type="text" name="title" id="title" class="form-control {{ ($errors->has('title')) ? 'is-invalid' : '' }}" placeholder="Enter Subscription Title" value="{{ $subscription->name }}">
                                            @if($errors->has('title'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('title') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="price" class="form-label">{{ __('Price')}}</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" name="price" id="price" class="form-control {{ ($errors->has('price')) ? 'is-invalid' : '' }}" placeholder="Enter Price" value="{{ $subscription->price }}">
                                                @if($errors->has('price'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('price') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="form-group">
                                            <label for="duration" class="form-label">{{ __('Duration')}}</label>
                                            <input type="number" name="duration" id="duration" class="form-control {{ ($errors->has('duration')) ? 'is-invalid' : '' }}" placeholder="Enter Duration" value="{{ $subscription->duration }}">
                                            @if($errors->has('duration'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('duration') }}
                                                </div>
                                            @endif
                                        </div>
                                        <small class="text-muted">{{ __('Enter Duration in Months')}}</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="status" class="form-label">{{ __('Status')}}</label><br>
                                            <input type="radio" name="status" value="1" id="active" {{ ($subscription->status == 1) ? 'checked' : '' }}> <label for="active">{{ __('Active')}}</label>
                                            <input type="radio" name="status" value="0" id="inactive" {{ ($subscription->status == 0) ? 'checked' : '' }}> <label for="inactive">{{ __('InActive')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="description" class="form-label">{{ __('Description')}}</label>
                                            <textarea name="description" id="description" rows="5" placeholder="Enter Subscription Description" class="form-control">{{ $subscription->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-success">{{ __('Update')}}</button>
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
