@extends('client.layouts.client-layout')

@section('title', 'Theme')

@section('content')

    <section class="theme_section">
        <div class="sec_title">
            <h2>Themes</h2>
            <p> Select a theme and preview your menu to check the result. Click on ‘Add theme’ and edit 	all available features.
            </p>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="item_box">
                    <div class="item_img add_category">
                        <a href="#" class="add_category_bt">
                            <i class="fa-solid fa-bolt icon_none"></i>
                        </a>
                        <div class="edit_item_bt">
                            <a href="{{route('design.theme-preview')}}" class="btn edit_item">Preview</a>
                            <button class="btn edit_category">Clone</button>
                        </div>
                        <!-- <a href="#" class="delet_bt">
                            <i class="fa-solid fa-trash"></i>
                        </a> -->
                    </div>
                    <div class="item_info">
                        <div class="item_name">
                            <h3>Default light theme</h3>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider round">
                                    <i class="fa-solid fa-circle-check check_icon"></i>
                                    <i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>
                                </span>
                            </label>
                        </div>
                        <h2>Theme</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="item_box">
                    <div class="item_img add_category">
                        <a href="#" class="add_category_bt">
                            <i class="fa-solid fa-bolt icon_none"></i>
                        </a>
                        <div class="edit_item_bt">
                            <a href="{{route('design.theme-preview')}}" class="btn edit_item">Preview</a>
                            <button class="btn edit_category">Clone</button>
                        </div>
                        <!-- <a href="#" class="delet_bt">
                            <i class="fa-solid fa-trash"></i>
                        </a> -->
                    </div>
                    <div class="item_info">
                        <div class="item_name">
                            <h3>Default light theme</h3>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider round">
                                    <i class="fa-solid fa-circle-check check_icon"></i>
                                    <i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>
                                </span>
                            </label>
                        </div>
                        <h2>Theme</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="item_box">
                    <div class="item_img add_category">
                        <a href="#" class="add_category_bt">
                            <i class="fa-solid fa-bolt icon_none"></i>
                        </a>
                        <div class="edit_item_bt">
                            <a href="{{route('design.theme-preview')}}" class="btn edit_item">Preview</a>
                            <button class="btn edit_category">Clone</button>
                        </div>
                        <!-- <a href="#" class="delet_bt">
                            <i class="fa-solid fa-trash"></i>
                        </a> -->
                    </div>
                    <div class="item_info">
                        <div class="item_name">
                            <h3>Default light theme</h3>
                            <label class="switch">
                                <input type="checkbox" checked>
                                <span class="slider round">
                                    <i class="fa-solid fa-circle-check check_icon"></i>
                                    <i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>
                                </span>
                            </label>
                        </div>
                        <h2>Theme</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="item_box">
                    <div class="item_img add_category">
                        <a href="#" class="add_category_bt">
                            <i class="fa-solid fa-image icon_none"></i>
                        </a>
                        <div class="edit_item_bt">
                            <a href="{{route('design.theme-preview')}}" class="btn edit_item">Preview</a>
                            <!-- <button class="btn edit_category">Clone</button> -->
                        </div>
                        <!-- <a href="#" class="delet_bt">
                            <i class="fa-solid fa-trash"></i>
                        </a> -->
                    </div>
                    <div class="item_info">
                        <div class="item_name">
                            <h3>Add theme</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

{{-- Custom JS --}}
{{-- @section('page-js')

    <script type="text/javascript">
        $("input[type='image']").click(function() {
            $("input[id='my_file']").click();
        });

    </script>

@endsection --}}
