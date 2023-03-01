{{-- Bootstrap --}}
<script src="{{ asset('public/client/assets/js/bootstrap.min.js') }}"></script>

{{-- Jquery --}}
<script src="{{ asset('public/client/assets/js/jquery.min.js') }}"></script>

{{-- Toastr --}}
<script src="{{ asset('public/admin/assets/vendor/js/toastr.min.js') }}"></script>


{{-- Common JS Functions --}}
<script type="text/javascript">

    // Toastr Settings
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        timeOut: 4000
    }

    // Function for Change Language
    function changeLanguage(langCode)
    {
        $.ajax({
            type: "POST",
            url: "{{ route('shop.locale.change') }}",
            data: {
                "_token" : "{{ csrf_token() }}",
                "lang_code" : langCode,
            },
            dataType: "JSON",
            success: function (response)
            {
                if(response.success == 1)
                {
                    location.reload();
                }
            }
        });
    }


    // Search Toggle
    $('#openSearchBox').on('click',function()
    {
        $(".search_input").addClass("d-block");
        $('#openSearchBox').addClass("d-none");
        $('#closeSearchBox').removeClass("d-none");
    });

    $('#closeSearchBox').on('click',function()
    {
        $("#closeSearchBox").addClass("d-none");
        $('#openSearchBox').removeClass("d-none");
        $(".search_input").removeClass("d-block");
    });

    // Open & Close Language Sidebar
    $('.lang_bt').on('click',function(){
        $(".lang_inr").addClass("sidebar");
    });
    $('.close_bt').on('click',function(){
        $(".lang_inr").removeClass("sidebar");
    });

</script>

