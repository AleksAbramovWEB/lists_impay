jQuery(document).ready(function ($){

    function impayAjax(search = '', until  = '', from = ''){
        $.ajax({
            url: impayListsData.url,
            type: 'POST',
            data:{
                 list_name: impayListsData.list_name,
                 action: 'impay_lists',
                 nonce: impayListsData.nonce,
                 search: search,
                 until: until,
                 from: from,
             },
            beforeSend: function (){
                if (!$("img").is(".loader_list"))
                   $('.count_string_list').append('<img class="loader_list" src="'+impayListsData.loader+'">')
            },
            success: function(data) { $('#impay_lists_data').html(data) },
            error: function (){ console.log('error') }
        });
    }

    $("#impay_lists_data").on('click', '#impay_paginate_button_next', function (){
        if ($(this).hasClass("disabled")) return;
        let search = $('#impay_lists_data_search').val();
        let until = $(this).attr('data-until');
        impayAjax( search, until );
    });

    $("#impay_lists_data").on('click', '#impay_paginate_button_previous', function (){
        if ($(this).hasClass("disabled")) return;
        let search = $('#impay_lists_data_search').val();
        let from = $(this).attr('data-from');
        impayAjax( search, '', from );
    });

    $('#impay_lists_data_search').on('input', function(){
        let search = $('#impay_lists_data_search').val();
        impayAjax( search );
    });

    $('#impay_lists_data').on('click', '.impay_list_string_title', function (){
        let hidden_info = $(this).siblings(".impay_list_hidden_info");
        let pointer = $(this).children('.dashicons');
        if (pointer.hasClass('dashicons-arrow-down'))
            hidden_info.fadeIn(200, function () {
                pointer.removeClass('dashicons-arrow-down')
                pointer.addClass('dashicons-arrow-up')
            });
        else hidden_info.fadeOut(200, function () {
            pointer.removeClass('dashicons-arrow-up')
            pointer.addClass('dashicons-arrow-down')
        });
    });




})