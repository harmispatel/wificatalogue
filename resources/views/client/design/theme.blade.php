@php
    $shop_settings = getClientSettings();
    $active_theme = isset($shop_settings['shop_active_theme']) ? $shop_settings['shop_active_theme'] : '';
@endphp

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

            @if(count($themes) > 0)
                @foreach ($themes as $theme)
                    <div class="col-md-3">
                        <div class="item_box">
                            <div class="item_img add_category">
                                <a class="add_category_bt">
                                    <i class="fa-solid fa-bolt icon_none"></i>
                                </a>
                                <div class="edit_item_bt">
                                    @if($theme->is_default == 0)
                                        <a href="{{ route('design.theme-preview',$theme->id) }}" class="btn edit_item">Edit</a>
                                    @endif
                                    <a href="{{ route('theme.clone',$theme->id) }}" class="btn edit_category">Clone</a>
                                </div>
                                @if($theme->is_default == 0)
                                    @if($active_theme != $theme->id)
                                        <a href="{{ route('theme.delete',$theme->id) }}" class="delet_bt">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    @endif
                                @endif
                            </div>
                            <div class="item_info">
                                <div class="item_name">
                                    <h3>{{ $theme->name }}</h3>
                                    <label class="switch">
                                        <input type="checkbox" name="is_default" id="is_default" {{ ($active_theme == $theme->id) ? 'checked disabled' : '' }} onchange="changeActiveTheme({{ $theme->id }})">
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
                @endforeach
            @endif

            {{-- <div class="col-md-3">
                <div class="item_box">
                    <div class="item_img add_category">
                        <a href="#" class="add_category_bt">
                            <i class="fa-solid fa-bolt icon_none"></i>
                        </a>
                        <div class="edit_item_bt">
                            <a href="{{route('design.theme-preview')}}" class="btn edit_item">Preview</a>
                            <button class="btn edit_category">Clone</button>
                        </div>
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
            </div> --}}

            <div class="col-md-3">
                <div class="item_box">
                    <div class="item_img add_category">
                        <a href="#" class="add_category_bt">
                            <i class="fa-solid fa-image icon_none"></i>
                        </a>
                        <div class="edit_item_bt">
                            <a href="{{ route('design.theme-create') }}" class="btn edit_item">Add New Theme</a>
                        </div>
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
@section('page-js')

    <script type="text/javascript">

        // Success Toastr Message
        @if (Session::has('success'))
            toastr.success('{{ Session::get('success') }}')
        @endif


        // Function for Change Active Theme
        function changeActiveTheme(themeID)
        {
            $.ajax({
                type: "POST",
                url: "{{ route('theme.change') }}",
                data: {
                    "_token" : "{{ csrf_token() }}",
                    "theme_id" : themeID,
                },
                dataType: "JSON",
                success: function (response)
                {
                    if(response.success == 1)
                    {
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                }
            });
        }

    </script>

@endsection
