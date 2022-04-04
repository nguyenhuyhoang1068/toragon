
jQuery(document).ready(function() { 
  jQuery('.dropdown-menu a.logout,.logout-item a span').one('click', function(e) {    
    call_ajax();
  });

  function call_ajax() {     
    jQuery.ajax({
        type: 'POST',
        async: true,
        url: ajax_object.ajax_url,
        data: {
          'action': 'custom_ajax_logout', //calls wp_ajax_nopriv_ajaxlogout
          'ajaxsecurity': ajax_object.logout_nonce
        },
        beforeSend: function() {},
        success: function(data) {
          window.location = ajax_object.home_url;
        },
        error: function(err) {}
    });
  }

});