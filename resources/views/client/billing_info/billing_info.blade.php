@extends('client.layouts.client-layout')

@section('title',__('Billing Info'))

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ __('Billing Information')}}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}">{{ __('Dashboard')}}</a></li>
                        <li class="breadcrumb-item active">{{ __('Billing Information')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">

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

            <div class="col-md-12">
                <form action="{{ route('update.billing.info') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <p>{{ __('You will not be able to select a payment method below, if your information is not updated.')}}</p>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            @php
                                                if(old('form_type') == 'receipt')
                                                {
                                                    $receipt_old_val = 'checked';
                                                }
                                                elseif (old('form_type') == 'invoice') {
                                                    $receipt_old_val = '';
                                                }
                                                else {
                                                    $receipt_old_val = 'checked';
                                                }
                                            @endphp
                                            <input class="form_type" type="radio" name="form_type" id="receipt" value="receipt" {{ $receipt_old_val }}> <label for="receipt">{{ __('Receipt')}}</label>
                                            <input class="form_type" type="radio" name="form_type" id="invoice" value="invoice" {{ (old('form_type') == 'invoice') ? 'checked' : '' }}> <label for="invoice">{{ __('Invoice')}}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ __('First Name')}}</label>
                                            <input type="text" name="firstname" id="firstname" class="form-control {{ ($errors->has('firstname')) ? 'is-invalid' : '' }}" placeholder="Plase Enter First Name" value="{{ $user->firstname }}">
                                            @if($errors->has('firstname'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('firstname') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ __('Last Name')}}</label>
                                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Plase Enter Last Name" value="{{ $user->lastname }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ __('Email')}}</label>
                                            <input type="text" name="email" id="email" value="{{ $user->email }}" class="form-control {{ ($errors->has('email')) ? 'is-invalid' : '' }}" placeholder="Plase Enter your Email">
                                            @if($errors->has('email'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('email') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ __('Company Name')}}</label>
                                            <input type="text" name="company" id="company" value="{{ $user->company }}" class="form-control" placeholder="Plase Enter your Company Name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ __('Address')}}</label>
                                            <input type="text" name="address" id="address" value="{{ $user->address }}" class="form-control" placeholder="Plase Enter your Address">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ __('City')}}</label>
                                            <input type="text" name="city" id="city" value="{{ $user->city }}" class="form-control" placeholder="Plase Enter your City">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{ __('Country')}}</label>
                                            <select class="form-select form-control" name="country" id="country">
                                                <option value="">Choose Your Country</option>
                                                @if(count($countries) > 0)
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}" {{ ($country->id == $user->country) ? 'selected' : '' }}>{{ $country->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">{{__('Zip')}}</label>
                                            <input type="text" name="zipcode" id="zipcode" value="{{ $user->zipcode }}" class="form-control" placeholder="Plase Enter your Zip">
                                        </div>
                                    </div>
                                    <div class="col-md-6 invoice_div" style="display: none;">
                                        <div class="form-group mb-3">
                                            <label for="vat_id" class="form-label">{{ __('VAT ID')}}</label>
                                            <input type="text" name="vat_id" id="vat_id" value="{{ $user->vat_id }}" class="form-control {{ ($errors->has('vat_id')) ? 'is-invalid' : '' }}" placeholder="Enter VAT ID">
                                            @if($errors->has('vat_id'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('vat_id') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 invoice_div" style="display: none;">
                                        <div class="form-group mb-3">
                                            <label for="gemi_id" class="form-label">{{ __('G.E.M.I ID')}}</label>
                                            <input type="text" name="gemi_id" id="gemi_id" class="form-control" placeholder="Enter G.E.M.I ID" value="{{ $user->gemi_id }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-success">{{ __('Update')}}</button>
                        </div>
                    </div>
                </form>
            </div>


            <div class="col-md-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3>{{ __('Current Plan')}}</h3>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Business Name')}}</th>
                                    <th>{{ __('Plan')}}</th>
                                    <th>{{ __('Status')}}</th>
                                    <th>{{ __('Remainig Days')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        {{ isset(Auth::user()->hasOneShop->shop['name']) ? Auth::user()->hasOneShop->shop['name'] : '' }}
                                    </td>
                                    <td>
                                        {{ isset(Auth::user()->hasOneSubscription->subscription['name']) ? Auth::user()->hasOneSubscription->subscription['name'] : '' }}
                                    </td>
                                    <td>
                                        @php
                                            $sub_status = (isset(Auth::user()->hasOneSubscription->subscription['status']) && Auth::user()->hasOneSubscription->subscription['status'] == 1) ? 'active' : 'nonactive';
                                        @endphp
                                        @if($sub_status == 'active')
                                            <span class="badge bg-success">{{ __('Active')}}</span>
                                        @else
                                            <span class="badge bg-danger">{{ __('NonActive')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <code class="fs-5">Your Subscription will Expire In {{ $expire_date }} Days.</code>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </section>


@endsection

@section('page-js')

    <script type="text/javascript">

        $(document).ready(function(){
            var selVal = $('input[name="form_type"]:checked').val();
            if(selVal == 'invoice')
            {
                $('.invoice_div').show();
            }
            else
            {
                $('.invoice_div').hide();
            }
        });

        $('#country').select2();

        // Show & Hide Invoice Fields
        $('.form_type').on('click',function(){
            var selectedVal = $(this).val();
            if(selectedVal == 'invoice')
            {
                $('.invoice_div').show();
            }
            else
            {
                $('.invoice_div').hide();
            }
        });

    </script>

@endsection
