jQuery(document).ready(function($) {

    jQuery(document).on('click', ".sfba_delete_entry", function() {
        var deleterowid = $(this).attr("data-delete");
        var wpappp_confirm_delete = window.confirm("Are you sure you want to delete Record with ID# " + deleterowid);
        var wpapp_redirect_refresh = window.location.href;
        if (wpappp_confirm_delete == true) {
            jQuery.ajax({
                type: 'POST',
                url: the_ajax_script.ajaxurl,
                data: { "action": "sfba_delete_db_record", "id": deleterowid, "wpnonce": the_ajax_script.ajax_nonce },
                success: function(data) {
                    location.href = window.location.href;
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus);
                    alert("Error: " + errorThrown);
                }
            });
        }
        // Prevents default submission of the form after clicking on the submit button. 
        return false;
    });

    jQuery(document).on('click', "#sfba_delete_all_data", function() {
        var wpappp_confirm_delete = window.confirm("Are you sure you want to delete all subscribers from the database?");
        var wpapp_redirect_refresh = window.location.href;
        if (wpappp_confirm_delete == true) {
            jQuery.ajax({
                type: 'POST',
                url: the_ajax_script.ajaxurl,
                data: { "action": "sfba_delete_db_data", "wpnonce": the_ajax_script.ajax_nonce },
                success: function(data) {
                    location.href = wpapp_redirect_refresh;
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus);
                    alert("Error: " + errorThrown);
                }
            });
        }
        // Prevents default submission of the form after clicking on the submit button. 
        return false;
    });



});