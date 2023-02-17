@extends('admin.layouts.admin-layout')

@section('title', 'Edit Client')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Clients</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('clients') }}">Clients</a></li>
                        <li class="breadcrumb-item active">Edit Clients</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <a href="{{ route('clients') }}" class="btn btn-sm new-amenity btn-primary">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- New Clients add Section --}}
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

            {{-- Clients Card --}}
            <div class="col-md-12">
                <div class="card">
                    <form class="form" action="{{ route('clients.update') }}" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="card-title">
                            </div>
                            @csrf
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Client Details</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <input type="hidden" name="client_id" id="client_id" value="{{ $client->id }}">
                                            <input type="hidden" name="shop_id" id="shop_id" value="{{ $client->hasOneShop['shop_id']}}">
                                            <input type="hidden" name="user_sub_id" id="user_sub_id" value="{{ isset($client->hasOneSubscription['subscription_id']) ? $client->hasOneSubscription['id'] : '' }}">
                                            <label for="name" class="form-label">Client Name</label>
                                            <input type="text" name="name" id="name" class="form-control {{ ($errors->has('name')) ? 'is-invalid' : '' }}" placeholder="Enter Client Name" value="{{ $client->name }}">
                                            @if($errors->has('name'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Client Email</label>
                                            <input type="text" name="email" id="email" class="form-control {{ ($errors->has('email')) ? 'is-invalid' : '' }}" placeholder="Enter Client Email" value="{{ $client->email }}">
                                            @if($errors->has('email'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('email') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" id="password" class="form-control {{ ($errors->has('password')) ? 'is-invalid' : '' }}" placeholder="Enter Password">
                                            @if($errors->has('password'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('password') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="confirm_password" class="form-label">Confirm Password</label>
                                            <input type="password" name="confirm_password" id="confirm_password" class="form-control {{ ($errors->has('confirm_password')) ? 'is-invalid' : '' }}" placeholder="Confirm Password">
                                            @if($errors->has('confirm_password'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('confirm_password') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="status" role="switch" id="status" value="1" {{ ($client->status == 1) ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="favourite" class="form-label">Favourite</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="favourite" role="switch" id="favourite" value="1" {{ ($client->is_fav == 1) ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h3>Shop Details</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="shop_name" class="form-label">Shop Name</label>
                                            <input type="text" name="shop_name" id="shop_name" class="form-control {{ ($errors->has('shop_name')) ? 'is-invalid' : '' }}" placeholder="Enter Shop Name" value="{{ $client->hasOneShop->shop['name'] }}">
                                            @if($errors->has('shop_name'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('shop_name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="shop_logo" class="form-label">Shop Logo</label>
                                            <input type="file" name="shop_logo" id="shop_logo" class="form-control">
                                        </div>
                                        <code>Upload Shop Logo (150*80) or (150*150)</code>
                                        <div class="form-group">
                                            <img width="70" src="{{ $client->hasOneShop->shop['logo'] }}" alt="">
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="shop_description" class="form-label">Shop Description</label>
                                            <textarea name="shop_description" id="shop_description" rows="5" class="form-control">{{ $client->hasOneShop->shop['description'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h3>Subscription Details</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="subscription" class="form-label">Subscriptions</label>
                                            <select name="subscription" id="subscription" class="form-control {{ ($errors->has('subscription')) ? 'is-invalid' : '' }}">
                                                <option value="">Select Subscription</option>
                                                @if (count($subscriptions) > 0)
                                                    @foreach ($subscriptions as $subscription)
                                                        <option value="{{ $subscription->id }}" {{ ($client->hasOneSubscription['subscription_id'] == $subscription->id) ? 'selected' : '' }}>{{ $subscription->name }} ({{$subscription->duration}} Months)</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if($errors->has('subscription'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('subscription') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
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
