@extends('client.layouts.client-layout')

@section('title', 'Contact')

@section('content')

    <section class="contact_main">
        <div class="sec_title">
            <h2>Contact US</h2>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label class="form-label">Title</label>
                    <input class="form-control" type="text">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label">Message</label>
                    <textarea name="" id="" class="form-control"></textarea>
                </div>
            </div>
        </div>
    </section>

@endsection


