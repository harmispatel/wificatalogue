@extends('client.layouts.client-layout')

@section('title',"Billing Info")

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Billing Information</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Billing Information</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-12">
                <code class="fs-4">Your Subscription has been Expired In {{ $expire_date }} Months.</code>
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
                                <p>You will not be able to select a payment method below, if your information is not updated.</p>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">First Name</label>
                                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Plase Enter First Name" value="{{ $user->firstname }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Last Name</label>
                                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Plase Enter Last Name" value="{{ $user->lastname }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="text" name="email" id="email" value="{{ $user->email }}" class="form-control" placeholder="Plase Enter your Email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Company Name</label>
                                            <input type="text" name="company" id="company" value="{{ $user->company }}" class="form-control" placeholder="Plase Enter your Company Name">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Address</label>
                                            <input type="text" name="address" id="address" value="{{ $user->address }}" class="form-control" placeholder="Plase Enter your Address">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">City</label>
                                            <input type="text" name="city" id="city" value="{{ $user->city }}" class="form-control" placeholder="Plase Enter your City">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Country</label>
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
                                            <label class="form-label">Zip</label>
                                            <input type="text" name="zipcode" id="zipcode" value="{{ $user->zipcode }}" class="form-control" placeholder="Plase Enter your Zip">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>


            <div class="col-md-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3>Current Plan</h3>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Business Name</th>
                                    <th>Plan</th>
                                    <th>Status</th>
                                    <th>Remainig Days</th>
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
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">NonActive</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $expire_date }} Months.
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

        $('#country').select2();

    </script>

@endsection
