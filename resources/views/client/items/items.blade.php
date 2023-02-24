@extends('client.layouts.client-layout')

@section('title', 'Items')

@section('content')

    {{-- Add Modal --}}
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemModalLabel">Create New Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addItemForm" enctype="multipart/form-data">
                        @csrf
                        {{-- <input type="hidden" name="category_id" id="category_id" value="{{ $category->id }}"> --}}
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="type" class="form-label">Type</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select name="type" id="type" onchange="togglePrice('add')" class="form-control">
                                        <option value="1">Product</option>
                                        <option value="2">Devider</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="category" class="form-label">Category</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Choose Category</option>
                                        @if(count($categories) > 0)
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ ($cat_id == $cat->id) ? 'selected' : '' }}>{{ $cat->en_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="name" class="form-label">Name</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Item Name">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="description" class="form-label">Description</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <textarea class="form-control" name="description" id="description" rows="5" placeholder="Item Description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="image" class="form-label">Image</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="file" name="image" id="image" class="form-control">
                                    <code>Upload Image in (200*200) Dimensions</code>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="ingredients" class="form-label">Ingredients</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select name="ingredients[]" id="ingredients" class="form-control" multiple>
                                        @if(count($ingredients) > 0)
                                            @foreach ($ingredients as $ingredient)
                                                <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="tags" class="form-label">Tags</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select name="tags[]" id="tags" class="form-control" multiple>
                                        @if(count($tags) > 0)
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="price" class="form-label">Price</label>
                            </div>
                            <div class="col-md-9 priceDiv" id="priceDiv">
                                <div class="row mb-3 align-items-center price price_1">
                                    <div class="col-md-5 mb-1">
                                        <input type="text" name="price[price][]" class="form-control" placeholder="Enter Price">
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        <input type="text" name="price[label][]" class="form-control" placeholder="Enter Price Label">
                                    </div>
                                    <div class="col-md-1 mb-1">
                                        <a onclick="$('.price_1').remove()" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4 priceDiv justify-content-end">
                            <div class="col-md-3">
                                <a onclick="addPrice('add')" class="btn addPriceBtn btn-info text-white">Add Price</a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="calories" class="form-label">Calories</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" name="calories" class="form-control" id="calories" placeholder="Enter Calories">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="switch me-2">
                                        <input type="checkbox" id="mark_new" name="is_new" value="1">
                                        <span class="slider round">
                                            <i class="fa-solid fa-circle-check check_icon"></i>
                                            <i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>
                                        </span>
                                    </label>
                                    <label for="mark_new" class="form-label">Mark Item as New</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="switch me-2">
                                        <input type="checkbox" id="mark_sign" name="is_sign" value="1">
                                        <span class="slider round">
                                            <i class="fa-solid fa-circle-check check_icon"></i>
                                            <i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>
                                        </span>
                                    </label>
                                    <label for="mark_sign" class="form-label">Mark Item as Signature</label>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <label class="switch me-2">
                                        <input type="checkbox" id="day_special" name="day_special" value="1">
                                        <span class="slider round">
                                            <i class="fa-solid fa-circle-check check_icon"></i>
                                            <i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>
                                        </span>
                                    </label>
                                    <label for="day_special" class="form-label">Mark Item as Day Special</label>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <label class="switch me-2">
                                        <input type="checkbox" id="publish" name="published" value="1">
                                        <span class="slider round">
                                            <i class="fa-solid fa-circle-check check_icon"></i>
                                            <i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>
                                        </span>
                                    </label>
                                    <label for="publish" class="form-label">Published</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a class="btn btn-primary" id="saveItem" onclick="saveItem()">Save</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editItemModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editItemForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="item_id" id="item_id" value="">
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="type" class="form-label">Type</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select name="type" onchange="togglePrice('edit')" id="type" class="form-control">
                                        <option value="1">Product</option>
                                        <option value="2">Devider</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="category" class="form-label">Category</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Choose Category</option>
                                        @if(count($categories) > 0)
                                            @foreach ($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->en_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="name" class="form-label">Name</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Item Name">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="description" class="form-label">Description</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <textarea class="form-control" name="description" id="description" rows="5" placeholder="Item Description"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="image" class="form-label">Image</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="file" name="image" id="image" class="form-control">
                                    <div class="mt-3" id="itemImage"></div>
                                    <code>Upload Image in (200*200) Dimensions</code>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="ingredients" class="form-label">Ingredients</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select name="ingredients[]" id="ingredients" class="form-control" multiple>
                                        @if(count($ingredients) > 0)
                                            @foreach ($ingredients as $ingredient)
                                                <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="tags" class="form-label">Tags</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <select name="tags[]" id="tags" class="form-control" multiple>
                                        @if(count($tags) > 0)
                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->name }}">{{ $tag->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="price" class="form-label">Price</label>
                            </div>
                            <div class="col-md-9 priceDiv" id="priceDiv">
                                <div class="row mb-3 align-items-center price price_1">
                                    <div class="col-md-5 mb-1">
                                        <input type="text" name="price[price][]" class="form-control" placeholder="Enter Price">
                                    </div>
                                    <div class="col-md-6 mb-1">
                                        <input type="text" name="price[label][]" class="form-control" placeholder="Enter Price Label">
                                    </div>
                                    <div class="col-md-1 mb-1">
                                        <a onclick="$('.price_1').remove()" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4 priceDiv justify-content-end">
                            <div class="col-md-3">
                                <a onclick="addPrice('add')" class="btn addPriceBtn btn-info text-white">Add Price</a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label for="calories" class="form-label">Calories</label>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <input type="text" name="calories" class="form-control" id="calories" placeholder="Enter Calories">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="switch me-2">
                                        <input type="checkbox" id="mark_new" name="is_new" value="1">
                                        <span class="slider round">
                                            <i class="fa-solid fa-circle-check check_icon"></i>
                                            <i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>
                                        </span>
                                    </label>
                                    <label for="mark_new" class="form-label">Mark Item as New</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="switch me-2">
                                        <input type="checkbox" id="mark_sign" name="is_sign" value="1">
                                        <span class="slider round">
                                            <i class="fa-solid fa-circle-check check_icon"></i>
                                            <i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>
                                        </span>
                                    </label>
                                    <label for="mark_sign" class="form-label">Mark Item as Signature</label>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <label class="switch me-2">
                                        <input type="checkbox" id="day_special" name="day_special" value="1">
                                        <span class="slider round">
                                            <i class="fa-solid fa-circle-check check_icon"></i>
                                            <i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>
                                        </span>
                                    </label>
                                    <label for="day_special" class="form-label">Mark Item as Day Special</label>
                                </div>
                            </div>
                            <div class="col-md-6 mt-2">
                                <div class="form-group">
                                    <label class="switch me-2">
                                        <input type="checkbox" id="publish" name="published" value="1">
                                        <span class="slider round">
                                            <i class="fa-solid fa-circle-check check_icon"></i>
                                            <i class="fa-sharp fa-solid fa-circle-xmark uncheck_icon"></i>
                                        </span>
                                    </label>
                                    <label for="publish" class="form-label">Published</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a class="btn btn-primary" id="updateItem" onclick="updateItem()">Update</a>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="editItemModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="item_lang_div">
                </div>
            </div>
        </div>
    </div> --}}

    {{-- EditTag Modal --}}
    <div class="modal fade" id="updateTagModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateTagModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateTagModalLabel">Edit Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateTagForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="tag_id" id="tag_id" value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="tag_name" id="tag_name" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a class="btn btn-primary" id="updateTag" onclick="updateTag()">Update</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Cat ID --}}
    <input type="hidden" name="cat_id" id="cat_id" value="{{ $cat_id }}">

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Items</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('categories') }}">Categories</a></li>
                        <li class="breadcrumb-item active">{{ (isset($category->en_name) && !empty($category->en_name)) ? $category->en_name : 'All' }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Items Section --}}
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
                                <select name="cat_filter" id="cat_filter" class="form-control">
                                    <option value="">Filter By Category</option>
                                    @if(count($categories) > 0)
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ ($cat_id == $category->id) ? 'selected' : '' }}>{{ $category->en_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
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
                            <h3>Tags</h3>
                        </div>
                        <div class="row mb-4 connectedSortableTags" id="tagsSorting">
                            {{-- Tags Section --}}
                            @if(count($cat_tags) > 0)
                                @foreach ($cat_tags as $tag)
                                    <div class="col-sm-2"  tag-id="{{ $tag->hasOneTag['id'] }}">
                                        <div class="product-tags">
                                            {{ $tag->hasOneTag['name'] }}
                                            <i class="fa fa-edit" onclick="editTag({{ $tag->hasOneTag['id'] }})" style="cursor: pointer"></i>
                                            <i class="fa fa-trash" onclick="deleteTag({{ $tag->hasOneTag['id'] }})" style="cursor: pointer"></i>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="sec_title">
                            <h3>Items</h3>
                        </div>
                        <div class="row connectedSortableItems" id="ItemSection">
                            {{-- Itens Section --}}
                            @if(count($items) > 0)
                                @foreach ($items as $item)
                                    <div class="col-md-3" item-id="{{ $item->id }}">
                                        <div class="item_box">
                                            <div class="item_img">
                                                <a href="#">
                                                    @if(!empty($item->image) && file_exists('public/client_uploads/items/'.$item->image))
                                                        <img src="{{ asset('public/client_uploads/items/'.$item->image) }}" class="w-100">
                                                    @else
                                                        <img src="{{ asset('public/client_images/not-found/no_image_1.jpg') }}" class="w-100">
                                                    @endif
                                                </a>
                                                <div class="edit_item_bt">
                                                    <button class="btn edit_category" onclick="editItem({{ $item->id }})">EDIT ITEM</button>
                                                </div>
                                                <a class="delet_bt" onclick="deleteItem({{ $item->id }})" style="cursor: pointer;">
                                                    <i class="fa-solid fa-trash"></i>
                                                </a>
                                            </div>
                                            <div class="item_info">
                                                <div class="item_name">
                                                    <h3>{{ $item->en_name }}</h3>
                                                    <div class="form-check form-switch">
                                                        @php
                                                            $newStatus = ($item->published == 1) ? 0 : 1;
                                                        @endphp
                                                        <input class="form-check-input" type="checkbox" name="status" role="switch" id="status" onclick="changeStatus({{ $item->id }},{{ $newStatus }})" value="1" {{ ($item->published == 1) ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                <h2>Product</h2>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            {{-- Add New Item Section --}}
                            <div class="col-md-3">
                                <div class="item_box">
                                    <div class="item_img add_category">
                                        <a data-bs-toggle="modal" data-bs-target="#addItemModal" class="add_category_bt" id="NewItemBtn">
                                            <i class="fa-solid fa-plus"></i>
                                        </a>
                                    </div>
                                    <div class="item_info text-center">
                                        <h2>Product</h2>
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

        // Reset AddItem Modal & Form
        $('#NewItemBtn').on('click',function()
        {
            // Reset addItemForm
            $('#addItemForm').trigger('reset');

            // Remove Validation Class
            $('#addItemForm #name').removeClass('is-invalid');
            $('#addItemForm #image').removeClass('is-invalid');

            // Clear all Toastr Messages
            toastr.clear();

            // Intialized Ingredients SelectBox
            $("#addItemForm #ingredients").select2({
                dropdownParent: $("#addItemModal"),
                placeholder: "Select Ingredients",
            });

            // Intialized Tags SelectBox
            $("#addItemForm #tags").select2({
                dropdownParent: $("#addItemModal"),
                placeholder: "Select Tags",
                tags: true,
                // tokenSeparators: [',', ' ']
            });

        });


        // Function for add New Price
        function addPrice(key)
        {
            if(key === 'add')
            {
                var formType = "#addItemForm #priceDiv";
            }
            else
            {
                var formType = "#editItemForm #priceDiv";
            }

            var count = $(formType).children('.price').length;
            var html = "";
            count ++;

            html += '<div class="row mb-3 align-items-center price price_'+count+'">';
                html += '<div class="col-md-5 mb-1">';
                    html += '<input type="text" name="price[price][]" class="form-control" placeholder="Enter Price">';
                html += '</div>';
                html += '<div class="col-md-6 mb-1">';
                    html += '<input type="text" name="price[label][]" class="form-control" placeholder="Enter Price Label">';
                html += '</div>';
                html += '<div class="col-md-1 mb-1">';
                    html += '<a onclick="$(\'.price_'+count+'\').remove()" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                html += '</div>';
            html += '</div>';

            $(formType).append(html);
        }



        // Save New Item
        function saveItem()
        {
            const myFormData = new FormData(document.getElementById('addItemForm'));

            // Remove Validation Class
            $('#addItemForm #name').removeClass('is-invalid');
            $('#addItemForm #image').removeClass('is-invalid');

            // Clear all Toastr Messages
            toastr.clear();

            $.ajax({
                type: "POST",
                url: "{{ route('items.store') }}",
                data: myFormData,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function (response)
                {
                    if(response.success == 1)
                    {
                        $('#addItemForm').trigger('reset');
                        $('#addItemModal').modal('hide');
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                    else
                    {
                        $('#addItemForm').trigger('reset');
                        $('#addItemModal').modal('hide');
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
                            $('#addItemForm #name').addClass('is-invalid');
                            toastr.error(nameError);
                        }

                        // Image Error
                        var imageError = (validationErrors.image) ? validationErrors.image : '';
                        if (imageError != '')
                        {
                            $('#addItemForm #image').addClass('is-invalid');
                            toastr.error(imageError);
                        }
                    }
                }
            });
        }



        // Function for Delete Item
        function deleteItem(itemId)
        {
            swal({
                title: "Are you sure You want to Delete It ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDeleteItem) =>
            {
                if (willDeleteItem)
                {
                    $.ajax({
                        type: "POST",
                        url: '{{ route("items.delete") }}',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id': itemId,
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



        // Function for Change Item Status
        function changeStatus(itemId, status)
        {
            $.ajax({
                type: "POST",
                url: '{{ route("items.status") }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'status':status,
                    'id':itemId
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



        // Function for Get Filterd Items
        $('#search').on('keyup',function()
        {
            var keywords = $(this).val();
            var catId = $('#cat_id').val();

            $.ajax({
                type: "POST",
                url: '{{ route("items.search") }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'keywords':keywords,
                    'id':catId,
                },
                dataType: 'JSON',
                success: function(response)
                {
                    if (response.success == 1)
                    {
                        $('#ItemSection').html('');
                        $('#ItemSection').append(response.data);
                    }
                    else
                    {
                        toastr.error(response.message);
                    }
                }
            });

        });


        // Function for Edit Item
        function editItem(itemId)
        {
            // Reset editItemForm
            $('#editItemForm').trigger('reset');

            // Remove Validation Class
            $('#editItemForm #name').removeClass('is-invalid');
            $('#editItemForm #image').removeClass('is-invalid');

            // Remove Old Seleted Value
            $('#editItemForm #category option:selected').removeAttr('selected');

            // Clear Image Div
            $('#editItemForm #itemImage').html('');

            // Reset Price Div
            $('#editItemForm #priceDiv').html('');

            // Intialized Ingredients SelectBox
            $("#editItemForm #ingredients").select2({
                dropdownParent: $("#editItemModal"),
                placeholder: "Select Ingredients",
            });

            // Intialized Tags SelectBox
            $("#editItemForm #tags").select2({
                dropdownParent: $("#editItemModal"),
                placeholder: "Select Tags",
                tags: true,
                // tokenSeparators: [',', ' ']
            });

            // Clear all Toastr Messages
            toastr.clear();

            $.ajax({
                type: "POST",
                url: "{{ route('items.edit') }}",
                dataType: "JSON",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': itemId,
                },
                success: function(response)
                {
                    if (response.success == 1)
                    {
                        // Item Data's
                        const item = response.item;
                        const ingredients = item.ingredients;
                        const product_tags = item.product_tags;

                        // Price
                        const price = item.price?.price;

                        if(ingredients != '')
                        {
                            // Set Selected option for Ingredients.
                            ingredients.forEach(ingredient =>
                            {
                                var ingredient_id = ingredient;
                                $("#editItemForm #ingredients").find("option[value=" + ingredient_id + "]").prop("selected","selected");
                            });
                            // Intialized Ingredients SelectBox
                            $("#editItemForm #ingredients").select2({
                                dropdownParent: $("#editItemModal"),
                                placeholder: "Select Ingredients",
                            });
                        }


                        if(product_tags != '')
                        {
                            // Set Selected option for Tags.
                            product_tags.forEach(tag =>
                            {
                                var tag_name = tag.has_one_tag.name;
                                $("#editItemForm #tags").find("option[value='" + tag_name + "']").prop("selected","selected");
                            });
                            // Intialized Tags SelectBox
                            $("#editItemForm #tags").select2({
                                dropdownParent: $("#editItemModal"),
                                placeholder: "Select Tags",
                                tags: true,
                                // tokenSeparators: [',', ' ']
                            });
                        }


                        if(price != undefined)
                        {
                            $.each(price, function (key, val)
                            {
                                var label = item.price.label[key];
                                var count = key+1;
                                var html = '';

                                html += '<div class="row mb-3 align-items-center price price_'+count+'">';
                                    html += '<div class="col-md-5 mb-1">';
                                        html += '<input type="text" name="price[price][]" class="form-control" placeholder="Enter Price" value="'+val+'">';
                                    html += '</div>';
                                    html += '<div class="col-md-6 mb-1">';
                                        html += '<input type="text" name="price[label][]" class="form-control" placeholder="Enter Price Label" value="'+label+'">';
                                    html += '</div>';
                                    html += '<div class="col-md-1 mb-1">';
                                        html += '<a onclick="$(\'.price_'+count+'\').remove()" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>';
                                    html += '</div>';
                                html += '</div>';

                                $('#editItemForm #priceDiv').append(html);
                            });
                        }

                        // Image
                        const default_image = "public/client_images/not-found/no_image_1.jpg";
                        const image_path = "public/client_uploads/items/"+item.image;
                        const item_image = (item.image) ? image_path : default_image;

                        // Published Status
                        const publish = (item.published) ? 1 : 0;

                        // Mark as New Status
                        const markNew = (item.is_new) ? 1 : 0;

                        // Mark as Signature Status
                        const markAsSign = (item.as_sign) ? 1 : 0;

                        // Mark as DaySpecial Status
                        const daySpecial = (item.day_special) ? 1 : 0;

                        // Add values in editItemForm
                        $('#editItemForm #name').val(item.en_name);
                        $('#editItemForm #calories').val(item.en_calories);
                        $('#editItemForm #description').val(item.en_description);
                        $('#editItemForm #item_id').val(item.id);

                        // Publish Status Check & Uncheck
                        if(publish == 1)
                        {
                            $('#editItemForm #publish').attr('checked',true);
                        }
                        else
                        {
                            $('#editItemForm #publish').removeAttr('checked',true);
                        }

                        // Mark as New Check & Uncheck
                        if(markNew == 1)
                        {
                            $('#editItemForm #mark_new').attr('checked',true);
                        }
                        else
                        {
                            $('#editItemForm #mark_new').removeAttr('checked',true);
                        }

                        // Mark as Day Special & Uncheck
                        if(daySpecial == 1)
                        {
                            $('#editItemForm #day_special').attr('checked',true);
                        }
                        else
                        {
                            $('#editItemForm #day_special').removeAttr('checked',true);
                        }

                        // Mark as Signature Check & Uncheck
                        if(markAsSign == 1)
                        {
                            $('#editItemForm #mark_sign').attr('checked',true);
                        }
                        else
                        {
                            $('#editItemForm #mark_sign').removeAttr('checked',true);
                        }

                        // Show Image in editItemForm
                        $('#editItemForm #itemImage').html('');
                        $('#editItemForm #itemImage').append('<img src="{{ asset('/') }}'+item_image+'" width="100">');

                        // Remove old Selected Options Value &  Set New Selected Option
                        $('#editItemForm #type option:selected').removeAttr('selected');
                        $("#editItemForm #type option[value='"+item.type+"']").attr("selected", "selected");

                        // if type == devider then hide price
                        if(item.type === 2)
                        {
                            $('.priceDiv').hide();
                        }
                        else
                        {
                            $('.priceDiv').show();
                        }

                        // Remove old Selected Options Value &  Set New Selected Option
                        $('#editItemForm #category option:selected').removeAttr('selected');
                        $("#editItemForm #category option[value='"+item.category_id+"']").attr("selected", "selected");

                        // Show Modal
                        $('#editItemModal').modal('show');
                    }
                    else
                    {
                        toastr.error(response.message);
                    }
                }
            });
        }

        // function editItem(itemID)
        // {
        //     // Reset All Form
        //     $('#editItemModal #item_lang_div').html('');

        //     // Clear all Toastr Messages
        //     toastr.clear();

        //     $.ajax({
        //         type: "POST",
        //         url: "{{ route('items.edit') }}",
        //         dataType: "JSON",
        //         data: {
        //             '_token': "{{ csrf_token() }}",
        //             'id': itemID,
        //         },
        //         success: function(response)
        //         {
        //             if (response.success == 1)
        //             {
        //                 $('#editItemModal #item_lang_div').html('');
        //                 $('#editItemModal #item_lang_div').append(response.data);

        //                 // Intialized Ingredients SelectBox
        //                 $("#editItemModal #ingredients").select2({
        //                     dropdownParent: $("#editItemModal"),
        //                     placeholder: "Select Ingredients",

        //                 });
        //                 $('#editItemModal').modal('show');
        //             }
        //             else
        //             {
        //                 toastr.error(response.message);
        //             }
        //         }
        //     });
        // }


        // Function for Update Item
        function updateItem()
        {
            const myFormData = new FormData(document.getElementById('editItemForm'));

            // Remove Validation Class
            $('#editItemForm #name').removeClass('is-invalid');
            $('#editItemForm #image').removeClass('is-invalid');

            // Clear all Toastr Messages
            toastr.clear();

            $.ajax({
                type: "POST",
                url: "{{ route('items.update') }}",
                data: myFormData,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function (response)
                {
                    if(response.success == 1)
                    {
                        $('#editItemForm #itemImage').html('');
                        $('#editItemForm').trigger('reset');
                        $('#editItemModal').modal('hide');
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                    else
                    {
                        $('#editItemForm').trigger('reset');
                        $('#editItemModal').modal('hide');
                        $('#editItemForm #itemImage').html('');
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
                            $('#editItemForm #name').addClass('is-invalid');
                            toastr.error(nameError);
                        }

                        // Image Error
                        var imageError = (validationErrors.image) ? validationErrors.image : '';
                        if (imageError != '')
                        {
                            $('#editItemForm #image').addClass('is-invalid');
                            toastr.error(imageError);
                        }

                        // Category Error
                        var categoryError = (validationErrors.category) ? validationErrors.category : '';
                        if (categoryError != '')
                        {
                            $('#editItemForm #category').addClass('is-invalid');
                            toastr.error(categoryError);
                        }
                    }
                }
            });

        }


        // Function for Hide & Show Price
        function togglePrice(formType)
        {
            if(formType === 'add')
            {
                var formID = "#addItemForm .priceDiv";
            }
            else
            {
                var formID = "#editItemForm .priceDiv";
            }

            var currVal = $('#type :selected').val();
            if(currVal == 2)
            {
                $(formID).hide();
            }
            else
            {
                var news= $(formID).show();
            }
        }



        // Function for Delete Tag
        function deleteTag(Id)
        {
            $.ajax({
                type: "POST",
                url: '{{ route("tags.destroy") }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'id': Id,
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



        // Function for Edit Tag
        function editTag(Id)
        {
            // Reset editItemForm
            $('#updateTagForm').trigger('reset');

            // Remove Validation Class
            $('#updateTagForm #tag_name').removeClass('is-invalid');

            // Clear all Toastr Messages
            toastr.clear();

            $.ajax({
                type: "POST",
                url: "{{ route('tags.edit') }}",
                dataType: "JSON",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': Id,
                },
                success: function(response)
                {
                    if (response.success == 1)
                    {
                        // Tag Data's
                        const tag = response.tag;

                        // Add values in editItemForm
                        $('#updateTagForm #tag_name').val(tag.name);
                        $('#updateTagForm #tag_id').val(tag.id);

                        // Show Modal
                        $('#updateTagModal').modal('show');
                    }
                    else
                    {
                        toastr.error(response.message);
                    }
                }
            });
        }


        // Function for Update Tag
        function updateTag()
        {
            const myFormData = new FormData(document.getElementById('updateTagForm'));

            // Remove Validation Class
            $('#updateTagForm #tag_name').removeClass('is-invalid');

            // Clear all Toastr Messages
            toastr.clear();

            $.ajax({
                type: "POST",
                url: "{{ route('tags.update') }}",
                data: myFormData,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function (response)
                {
                    if(response.success == 1)
                    {
                        $('#updateTagForm').trigger('reset');
                        $('#updateTagModal').modal('hide');
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                    else
                    {
                        $('#updateTagForm').trigger('reset');
                        $('#updateTagModal').modal('hide');
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
                        var nameError = (validationErrors.tag_name) ? validationErrors.tag_name : '';
                        if (nameError != '')
                        {
                            $('#updateTagForm #tag_name').addClass('is-invalid');
                            toastr.error(nameError);
                        }
                    }
                }
            });

        }


        $( function()
        {
            // Sorting Tags
            $( "#tagsSorting" ).sortable({
                connectWith: ".connectedSortableTags",
                opacity: 0.5,
            }).disableSelection();

            $( ".connectedSortableTags" ).on( "sortupdate", function( event, ui )
            {
                var tagsArr = [];

                $("#tagsSorting .col-sm-2").each(function( index )
                {
                    tagsArr[index] = $(this).attr('tag-id');
                });

                $.ajax({
                    type: "POST",
                    url: '{{ route("tags.sorting") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'sortArr': tagsArr,
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



            // Sorting Items
            $( "#ItemSection" ).sortable({
                connectWith: ".connectedSortableItems",
                opacity: 0.5,
            }).disableSelection();

            $( ".connectedSortableItems" ).on( "sortupdate", function( event, ui )
            {
                var itemsArr = [];

                $("#ItemSection .col-md-3").each(function( index )
                {
                    itemsArr[index] = $(this).attr('item-id');
                });

                $.ajax({
                    type: "POST",
                    url: '{{ route("items.sorting") }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'sortArr': itemsArr,
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

        // Function for Get Items By Category ID
        $('#cat_filter').on('change',function(){
            var catID = $('#cat_filter :selected').val();
            var Url = "{{ route('items') }}";
            location.href = Url+"/"+catID;
        });

    </script>

@endsection
