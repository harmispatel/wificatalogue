<!-- Favicons -->
{{-- <link href="{{ asset('admin_images/demo_images/favicons/home.png') }}" rel="icon"> --}}

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="{{ asset('public/admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/admin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('public/admin/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/admin/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
<link href="{{ asset('public/admin/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
<link href="{{ asset('public/admin/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
<link href="{{ asset('public/admin/assets/css/custom.css') }}" rel="stylesheet">

<!-- icon -->
{{-- font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"/>

{{-- DataTable --}}
<link href="{{ asset('public/admin/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

<!-- Template Main CSS File -->
<link href="{{ asset('public/admin/assets/vendor/css/style.css') }}" rel="stylesheet">

{{-- Jquey UI --}}
<link rel="stylesheet" href="{{ asset('public/admin/assets/vendor/css/jquery-ui.css') }}">

{{-- Toastr CSS --}}
<link rel="stylesheet" href="{{ asset('public/admin/assets/vendor/css/toastr.min.css') }}">

{{-- Select 2 CSS --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- custom css -->
<link rel="stylesheet" type="text/css" href="{{ asset('public/client/assets/css/custom.css') }}">

{{-- Custom CSS --}}
<style>
    /* select 2 css */
    .select2 {
        width: 100%!important;
    }
    .select2-selection{
        min-height: 37px!important;
    }
    .select2-container .select2-search--inline .select2-search__field{
        height:22px;
    }
    .select2-container--default .select2-selection--multiple{
        border: 1px solid #ced4da!important;
    }

    /* Product Tags */
    .product-tags {
        background: #f1f3f7;
        padding: 10px;
        display: flex;
        align-items: center;
        justify-content: space-around;
        border-radius: 5px;
        color: rgb(0 0 0 / 65%);
        margin-bottom: 15px;
        cursor: move;
    }

    /* categorySection */
    #categorySection .col-md-3{
        cursor: move;
    }
</style>
