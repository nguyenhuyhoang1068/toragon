jQuery(document).ready(function() {       
    jQuery('.es_subscription_form_submit').click( function(e) {
    //jQuery('.es_subscription_form_submit').one('click', function(e) {
  
        var email = jQuery('.ig_es_form_field_email').val();
        jQuery.ajax({
            type: 'POST',
            url: directory_search_params.ajaxurl,
            data: { "action": "sytp_insert_db_record", "email": email },
            success: function(data) {              
              if (data.success == true) { 
                jQuery('#es_subscription_message').html(data.data); 
                jQuery('#es_form_f1-n1 .form-control').val('');
              }                   
                //document.getElementById('es_subscription_message').innerHTML = data;
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("Status: " + textStatus);
                alert("Error: " + errorThrown);
            }
        });
  
    });  
    
  });