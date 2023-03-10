@php
    $shop_id = isset(Auth::user()->hasOneShop->shop['id']) ? Auth::user()->hasOneShop->shop['id'] : "";
    $primary_lang_details = clientLanguageSettings($shop_id);

    $language = getLangDetails(isset($primary_lang_details['primary_language']) ? $primary_lang_details['primary_language'] : '');
    $language_code = isset($language['code']) ? $language['code'] : '';
    $name_key = $language_code."_name";
@endphp

@extends('client.layouts.client-layout')

@section('title', 'Tags')

@section('content')

    {{-- Tags Edit Modal --}}
    <div class="modal fade" id="editTagModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editTagModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTagModalLabel">Edit Tag</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="tag_lang_div">
                </div>
            </div>
        </div>
    </div>

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>{{ __('Tags')}}</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a>{{ __('Tags')}}</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

     {{-- Tags Section --}}
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

            {{-- Tags Card --}}
            <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped w-100" id="tagsTable">
                            <thead>
                                <tr>
                                    <th>{{ __('Id')}}</th>
                                    <th>{{ __('Name')}}</th>
                                    <th>{{ __('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tags as $tag)
                                    @php
                                        $tag_name = (isset($tag->$name_key) && !empty($tag->$name_key)) ? $tag->$name_key : $tag->name;
                                    @endphp
                                    <tr>
                                        <td>{{ $tag->id }}</td>
                                        <td>{{ $tag_name }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-primary" onclick="editTag({{ $tag->id }})">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="text-center">
                                        <td colspan="3">
                                            Tags Not Found !
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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

        // Function for Edit Tag
        function editTag(tagID)
        {
            // Reset All Form
            $('#editCategoryModal #tag_lang_div').html('');

            // Clear all Toastr Messages
            toastr.clear();

            $.ajax({
                type: "POST",
                url: "{{ route('language.tags.edit') }}",
                dataType: "JSON",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': tagID,
                },
                success: function(response)
                {
                    if (response.success == 1)
                    {
                        $('#editTagModal #tag_lang_div').html('');
                        $('#editTagModal #tag_lang_div').append(response.data);
                        $('#editTagModal').modal('show');
                    }
                    else
                    {
                        toastr.error(response.message);
                    }
                }
            });
        }


        // Function for Update Tag
        function updateTag(langCode)
        {
            var formID = langCode+"_tag_form";
            var myFormData = new FormData(document.getElementById(formID));

            // Remove Validation Class
            $("#"+formID+' #tag_name').removeClass('is-invalid');

            // Clear all Toastr Messages
            toastr.clear();

            $.ajax({
                type: "POST",
                url: "{{ route('language.tags.update') }}",
                data: myFormData,
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData: false,
                success: function (response)
                {
                    if(response.success == 1)
                    {
                        $('#editTagModal').modal('hide');
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                    else
                    {
                        $('#editTagModal').modal('hide');
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
                        var nameError = (validationErrors.tag_name) ? validationErrors.tag_name : '';
                        if (nameError != '')
                        {
                            $("#"+formID+' #tag_name').addClass('is-invalid');
                            toastr.error(nameError);
                        }
                    }
                }
            });
        }

    </script>

@endsection
