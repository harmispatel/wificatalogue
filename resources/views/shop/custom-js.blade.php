<script type="text/javascript">

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
