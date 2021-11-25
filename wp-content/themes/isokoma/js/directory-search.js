jQuery(document).ready(function() {

    var timeout = null; // khai báo biến timeout
    if (jQuery('.directory-wrap').length != 0) {
        var html_original = document.getElementById('content-box').innerHTML
        jQuery(".search-ajax").keyup(function() { // bắt sự kiện khi gõ từ khóa tìm kiếm
            clearTimeout(timeout); // clear time out
            var data = jQuery('.search-ajax').val();
            timeout = setTimeout(function() {
                if (data.trim().length === 0) {
                    return document.getElementById('content-box').innerHTML = html_original;
                }
                if (data.length < 2) {
                    showNoticeSearch();
                    return document.getElementById('content-box').innerHTML = html_original;
                } else {
                    hideNoticeSearch();
                    call_ajax(); // gọi hàm ajax
                }
            }, 500);
        });
        jQuery('.search-icon').one('click', function(e) {
            call_ajax();
        });
    }
    jQuery('.es_subscription_form_submit').one('click', function(e) {
  
        var email = jQuery('.ig_es_form_field_email').val();
        jQuery.ajax({
            type: 'POST',
            url: directory_search_params.ajaxurl,
            data: { "action": "sytp_insert_db_record", "email": email },
            success: function(data) {
                document.getElementById('es_subscription_message').innerHTML = data;
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);
            }
        });
  
    });
  
    function call_ajax() { // khởi tạo hàm ajax
        var data = jQuery('.search-ajax').val(); // get dữ liệu khi đang nhập từ khóa vào ô
        $.ajax({
            type: 'POST',
            async: true,
            url: directory_search_params.ajaxurl,
            data: {
                'action': 'Post_filters',
                'data': data
            },
            beforeSend: function() {},
            success: function(data) {
              console.log(data);
                document.getElementById('content-box').innerHTML = data; 
            },
            error: function(err) {}
        });
    }
  
    function showNoticeSearch() {
        jQuery('.notice-search').removeClass('d-none')
    }
  
    function hideNoticeSearch() {
        jQuery('.notice-search').addClass('d-none')
    }
  });