@extends('client.layouts.client-layout')

@section('title', 'Language')

@section('content')

    <section class="lang_main">
        <div class="row">
            <div class="col-md-3">
                <div class="lang_sidebar">
                    <div class="lang_title">
                        <h2>Menu</h2>
                    </div>
                    <ul class="lang_menu_ul">
                        <li>
                            <a href="#">
                                <span><i class="fa-solid fa-chevron-right me-3"></i></span>
                                <span><i class="fa-solid fa-cart-shopping me-1"></i> Menu 1</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span><i class="fa-solid fa-chevron-right me-3"></i></span>
                                <span><i class="fa-solid fa-cart-shopping me-1"></i> Menu 1</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span><i class="fa-solid fa-chevron-right me-3"></i></span>
                                <span><i class="fa-solid fa-cart-shopping me-1"></i> Menu 1</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span><i class="fa-solid fa-chevron-right me-3"></i></span>
                                <span><i class="fa-solid fa-cart-shopping me-1"></i> Menu 1</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span><i class="fa-solid fa-chevron-right me-3"></i></span>
                                <span><i class="fa-solid fa-cart-shopping me-1"></i> Menu 1</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span><i class="fa-solid fa-chevron-right me-3"></i></span>
                                <span><i class="fa-solid fa-cart-shopping me-1"></i> Menu 1</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span><i class="fa-solid fa-chevron-right me-3"></i></span>
                                <span><i class="fa-solid fa-cart-shopping me-1"></i> Menu 1</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span><i class="fa-solid fa-chevron-right me-3"></i></span>
                                <span><i class="fa-solid fa-cart-shopping me-1"></i> Menu 1</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span><i class="fa-solid fa-chevron-right me-3"></i></span>
                                <span><i class="fa-solid fa-cart-shopping me-1"></i> Menu 1</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span><i class="fa-solid fa-chevron-right me-3"></i></span>
                                <span><i class="fa-solid fa-cart-shopping me-1"></i> Menu 1</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="lang_right_side">
                    <div class="lang_title">
                        <h2>Translations</h2>
                        <p>On the left you can find your menu's structure. Click on every menu element and insert the translation of the selected additional languages. Note that primary language descriptions can only be changed through ‘Menu’ tab features.</p>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Email address</label>
                                <select class="form-select form-control" aria-label="Default select example">
                                    <option selected>English</option>
                                    <option value="1">German</option>
                                    <option value="2">French</option>
                                    <option value="3">Urdu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Email address</label>
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Google translate</label>
                                <br/>
                                <label class="switch">
                                    <input type="checkbox" checked>
                                    <span class="slider round">
                                        <i class="fa-solid fa-circle-check check_icon"></i>
                                        <i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

{{-- Custom JS --}}

