@extends('admin.layouts.admin-layout')

@section('title',"Import - Export")

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Import / Export</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Import / Export</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Clients Section --}}
    <section class="section dashboard">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>Import and Export</h3>
                                </div>
                                <div class="col-md-6">
                                    <a class="btn btn-primary" href="{{ asset('public/csv_demo/category_item_demo.xlsx') }}" download><i class="fa fa-download"></i> Download Demo CSV</a>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('admin.import.data') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shop" class="form-label">Client Shop</label>
                                        <select name="shop" id="shop" class="form-select form-control {{ ($errors->has('shop')) ? 'is-invalid' : '' }}">
                                            <option value="">Choose Shop</option>
                                            @if(count($shops) > 0)
                                                @foreach ($shops as $shop)
                                                    <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if($errors->has('shop'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('shop') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="import" class="form-label">Import Data</label>
                                        <input type="file" name="import" id="import" class="form-control {{ ($errors->has('import')) ? 'is-invalid' : '' }}">
                                        @if($errors->has('import'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('import') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button class="btn btn-success">Import</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection

@section('page-js')

    <script type="text/javascript">

        $('#shop').select2();

        @if (Session::has('success'))
            toastr.success('{{ Session::get('success') }}')
        @endif

        @if (Session::has('error'))
            toastr.error('{{ Session::get('error') }}')
        @endif

    </script>

@endsection
