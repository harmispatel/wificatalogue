@extends('client.layouts.client-layout')

@section('title', 'Dashboard')

@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Dashboard Section --}}
    <section class="section dashboard">
        <div class="row">
            {{-- Errors Message --}}
            @if (session()->has('errors'))
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('errors') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

        </div>
    </section>
@endsection

{{-- Custom JS --}}
@section('page-js')

    <script type="text/javascript">
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            timeOut: 4000
        }

        @if (Session::has('success'))
            toastr.success('{{ Session::get('success') }}')
        @endif

    </script>

@endsection
