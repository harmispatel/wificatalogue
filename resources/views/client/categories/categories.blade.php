@extends('client.layouts.client-layout')

@section('title', __('Categories'))

@section('content')

    {{-- Edit Modal --}}
    <div class="modal fade" id="editCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">{{ __('Edit Category')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="cat_lang_div">
                </div>
            </div>
        </div>
    </div>

    {{-- Add Modal --}}
    <div class="modal fade" id="addCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">{{ __('Create New category')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addCategoryForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="input_label">
                                    <label class="form-label" for="name">{{ __('Name')}}</label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group mb-3">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Category Title">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input_label">
                                    <label class="form-label" for="description">{{ __('Description')}}</label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group mb-3">
                                    <textarea class="form-control" name="description" id="description" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input_label">
                                    <label class="form-label" for="image">{{ __('Image')}}</label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group mb-3">
                                   <input type="file" name="image" id="image" class="form-control">
                                   <code>Upload Image in (200*200) Dimensions</code>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input_label">
                                    <label class="form-label" for="publish">{{ __('Published')}}</label>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="form-group mb-3">
                                    <label class="switch">
                                        <input type="checkbox" id="publish" name="published" value="1">
                                        <span class="slider round">
                                            <i class="fa-solid fa-circle-check check_icon"></i>
                                            <i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close')}}</button>
                        <a class="btn btn-primary" id="saveCategory" onclick="saveCategory()">{{ __('Save')}}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ __('Categories')}}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('client.dashboard') }}">Dashboard</a></li> --}}
                        <li class="breadcrumb-item active">{{ __('Categories')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Clients Section --}}
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

            <div class="main_section">
                <div class="container-fluid">
                    <div class="main_section_inr">
                        <div class="row justify-content-end">
                            <div class="col-md-4">
                                <div class="search_box">
                                    <div class="form-group position-relative">
                                        <input type="text" id="search" class="form-control" placeholder="Search">
                                        <i class="fa-solid fa-magnifying-glass search_icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sec_title">
                            <h1>{{ __('Categories')}}</h1>
                            <p> {{ __('Menu categories define the core structure of your menu. Move your mouse over a category to ‘Add or edit category items’ (aka products) or ‘Edit category’')}}
                            </p>
                        </div>
                        <div class="row connectedSortableCategory" id="categorySection">

                            {{-- Categories Section --}}
                            @if(count($categories) > 0)
                                @foreach ($categories as $category)
                                    <div class="col-md-3 catDiv" cat-id="{{ $category->id }}">
                                        <div class="item_box">
                                            <div class="item_img">
                                                <a href="#">
                                                    @if(!empty($category->image) && file_exists('public/client_uploads/categories/'.$category->image))
                                                        <img src="{{ asset('public/client_uploads/categories/'.$category->image) }}" class="w-100">
                                                    @else
                                                        <img src="{{ asset('public/client_images/not-found/no_image_1.jpg') }}" class="w-100">
                                                    @endif
                                                </a>
                                                <div class="edit_item_bt">
                                                    <a href="{{ route('items',$category->id) }}" class="btn edit_item" >{{ __('ADD OR EDIT ITEMS')}}</a>
                                                    <button class="btn edit_category" onclick="editCategory({{ $category->id }})">{{ __('EDIT CATEGORY')}}</button>
                                                </div>
                                                <a class="delet_bt" onclick="deleteCategory({{ $category->id }})" style="cursor: pointer;">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </div>
                                            <div class="item_info">
                                                <div class="item_name">
                                                    <h3>{{ $category->en_name }}</h3>
                                                    <div class="form-check form-switch">
                                                        @php
                                                            $newStatus = ($category->published == 1) ? 0 : 1;
                                                        @endphp
                                                        <input class="form-check-input" type="checkbox" name="status" role="switch" id="status" onclick="changeStatus({{ $category->id }},{{ $newStatus }})" value="1" {{ ($category->published == 1) ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                <h2>{{ __('Item Category')}}</h2>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            {{-- Add New Category Section --}}
                            <div class="col-md-3">
                                <div class="item_box">
                                    <div class="item_img add_category">
                                        <a data-bs-toggle="modal" data-bs-target="#addCategoryModal" class="add_category_bt" id="NewCategoryBtn">
                                            <i class="fa-solid fa-plus"></i>
                                        </a>
                                    </div>
                                    <div class="item_info text-center">
                                        <h2>{{ __('Add New Category')}}</h2>
                                    </div>
                                </div>
                            </div>
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

        // Reset New CategoryForm
        $('#NewCategoryBtn').on('click',function(){

            // Reset NewCategoryForm
            $('#addCategoryForm').trigger('reset');

            // Remove Validation Class
            $('#addCategoryForm #name').removeClass('is-invalid');
            $('#addCategoryForm #image').removeClass('is-invalid');

            // Clear all Toastr Messages
            toastr.clear();

        });



        // Save New Category
        function saveCategory()
        {
            const myFormData = new FormData(document.getElementById('addCategoryForm'));

            // Remove Validation Class
            $('#addCategoryForm #name').removeClass('is-invalid');
            $('#addCategoryForm #image').removeClass('is-invalid');

            // Clear all Toastr Messages
            toastr.clear();

            $.ajax({
                type: "POST",
                url: "{{ route('categories.store') }}",
                data: myFormData,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function (response)
                {
                    if(response.success == 1)
                    {
                        $('#addCategoryForm').trigger('reset');
                        $('#addCategoryModal').modal('hide');
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                    else
                    {
                        $('#addCategoryForm').trigger('reset');
                        $('#addCategoryModal').modal('hide');
                        toastr.error(response.message);
                    }
                },
                error: function(response)
                {
                    // All Validation Errors
                    const validationErrors = (response?.responseJSON?.errors) ? response.responseJSON.errors : '';

                    if (validationErrors != '')
                    {
                        // Name Error
                        var nameError = (validationErrors.name) ? validationErrors.name : '';
                        if (nameError != '')
                        {
                            $('#addCategoryForm #name').addClass('is-invalid');
                            toastr.error(nameError);
                        }

                        // Image Error
                        var imageError = (validationErrors.image) ? validationErrors.image : '';
                        if (imageError != '')
                        {
                            $('#addCategoryForm #image').addClass('is-invalid');
                            toastr.error(imageError);
                        }
                    }
                }
            });
        }



        // Function for Delete Category
        function deleteCategory(catId)
        {
            swal({
                title: "Are you sure You want to Delete It ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDeleteCategory) =>
            {
                if (willDeleteCategory)
                {
                    $.ajax({
                        type: "POST",
                        url: '{{ route("categories.delete") }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id': catId,
                        },
                        dataType: 'JSON',
                        success: function(response)
                        {
                            if (response.success == 1)
                            {
                                toastr.success(response.message);
                                setTimeout(() => {
                                    location.reload();
                                }, 1300);
                            }
                            else
                            {
                                toastr.error(response.message);
                            }
                        }
                    });
                }
                else
                {
                    swal("Cancelled", "", "error");
                }
            });
        }



        // Function for Edit Category
        function editCategory(catID)
        {
            // Reset All Form
            $('#editCategoryModal #cat_lang_div').html('');

            // Clear all Toastr Messages
            toastr.clear();

            $.ajax({
                type: "POST",
                url: "{{ route('categories.edit') }}",
                dataType: "JSON",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': catID,
                },
                success: function(response)
                {
                    if (response.success == 1)
                    {
                        $('#editCategoryModal #cat_lang_div').html('');
                        $('#editCategoryModal #cat_lang_div').append(response.data);
                        $('#editCategoryModal').modal('show');
                    }
                    else
                    {
                        toastr.error(response.message);
                    }
                }
            });

        }



        // Function for Update Category
        function updateCategory(langCode)
        {
            var formID = langCode+"_category_form";
            var myFormData = new FormData(document.getElementById(formID));

            // Remove Validation Class
            $("#"+formID+' #category_name').removeClass('is-invalid');
            $("#"+formID+' #category_image').removeClass('is-invalid');

            // Clear all Toastr Messages
            toastr.clear();

            $.ajax({
                type: "POST",
                url: "{{ route('categories.update') }}",
                data: myFormData,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function (response)
                {
                    if(response.success == 1)
                    {
                        $('#editCategoryModal').modal('hide');
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                    else
                    {
                        $('#editCategoryModal').modal('hide');
                        toastr.error(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                },
                error: function(response)
                {
                    // All Validation Errors
                    const validationErrors = (response?.responseJSON?.errors) ? response.responseJSON.errors : '';

                    if (validationErrors != '')
                    {
                        // Name Error
                        var nameError = (validationErrors.category_name) ? validationErrors.category_name : '';
                        if (nameError != '')
                        {
                            $("#"+formID+' #category_name').addClass('is-invalid');
                            toastr.error(nameError);
                        }

                        // Image Error
                        var imageError = (validationErrors.category_image) ? validationErrors.category_image : '';
                        if (imageError != '')
                        {
                            $("#"+formID+' #category_image').addClass('is-invalid');
                            toastr.error(imageError);
                        }
                    }
                }
            });

        }



        // Function for Change Category Status
        function changeStatus(catId, status)
        {
            $.ajax({
                type: "POST",
                url: '{{ route("categories.status") }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'status':status,
                    'id':catId
                },
                dataType: 'JSON',
                success: function(response)
                {
                    if (response.success == 1)
                    {
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1300);
                    }
                    else
                    {
                        toastr.error(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1300);
                    }
                }
            });
        }



        // Function for Get Filterd Categories
        $('#search').on('keyup',function()
        {
            var keywords = $(this).val();

            $.ajax({
                type: "POST",
                url: '{{ route("categories.search") }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'keywords':keywords,
                },
                dataType: 'JSON',
                success: function(response)
                {
                    if (response.success == 1)
                    {
                        $('#categorySection').html('');
                        $('#categorySection').append(response.data);
                    }
                    else
                    {
                        toastr.error(response.message);
                    }
                }
            });

        });

        $( function()
        {
            // Sorting Categories
            $( "#categorySection" ).sortable({
                connectWith: ".connectedSortableCategory",
                opacity: 0.5,
            }).disableSelection();

            $( ".connectedSortableCategory" ).on( "sortupdate", function( event, ui )
            {
                var catArray = [];

                $("#categorySection .catDiv").each(function( index )
                {
                    catArray[index] = $(this).attr('cat-id');
                });

                console.log(catArray);

                $.ajax({
                    type: "POST",
                    url: '{{ route("categories.sorting") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'sortArr': catArray,
                    },
                    dataType: 'JSON',
                    success: function(response)
                    {
                        if (response.success == 1)
                        {
                            toastr.success(response.message);
                        }
                    }
                });
            });


        });

    </script>

@endsection
