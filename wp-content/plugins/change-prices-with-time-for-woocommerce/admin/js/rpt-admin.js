(function( $ ) {
	'use strict';

	$(function(){
		
	 	// Adding a new row
	 	$( document ).on( 'click', '.rpt-add-row', function(){

			var table = $(this).parent().find('.wc-rpt-table');
			var tbody = table.find('tbody');
	 		var length = tbody.children('tr').length;
			var name   = $(this).attr('data-formname') || 'rpt_wc';
	 		var _template = wp.template( 'rpt_table_row_template' );
			var html = _template({ length: length, name: name });
			

			tbody.append( html );
 			$(".rpt-date-column .rpt-datepicker").datepicker({
	        	dateFormat : 'dd-mm-yy',
	   		});
			$( document.body ).trigger( 'wc-enhanced-select-init' );
	 	});

	 	$( document ).on( 'click', '.rpt-delete', function(){
			var table = $(this).parents('.wc-rpt-table'),
				variation = $(this).parents('.woocommerce_variation');
	 		$(this).parent().parent().remove();

	 		if ( variation.length ) {
	 			variation.addClass('variation-needs-update');

                // Disable cancel and save buttons
                $( 'button.cancel-variation-changes, button.save-variation-changes' ).removeAttr( 'disabled' );
			}

	 		rpt_refresh_table_body( table );
	 	});

	 	/**
	 	 * Refreshed table body
	 	 * @return void 
	 	 */
	 	function rpt_refresh_table_body( table ) {
			var table = table || $('.wc-rpt-table'),
				name  = table.attr( 'data-formname' );
	 		var count = 0;
 
	 		table.find('tbody').find('tr').each(function(){
	 			var row = $(this);
	 			row.find('.rpt-date-column input').attr( 'name', name + '[' + count + '][date]' );
	 			row.find('.rpt-time-column select').attr( 'name', name + '[' + count + '][time]' );
	 			row.find('.rpt-price-column input').attr( 'name', name + '[' + count + '][price]' );
	 			count++;
	 		});
	 	}

        $( document ).on( 'click', '.rpt-add-row-bundle', function(){

            var table = $(this).parent().find('.wc-rpt-table');
            var tbody = table.find('tbody');
            var length = tbody.children('tr').length;
            var name   = $(this).attr('data-formname') || 'rpt_wc';
            var _template = wp.template( 'rpt_table_bundle_row_template' );
            var html = _template({ length: length, name: name });

            tbody.append( html );
            $(".rpt-date-column .rpt-datepicker").datepicker({
                dateFormat : 'dd-mm-yy',
            });
        });

        $( document ).on( 'click', '.rpt-delete-bundle', function(){
            var table = $(this).parents('.wc-rpt-table');
            $(this).parents('tr').remove();
            rpt_refresh_bundle_table_body( table );
        });

        function rpt_refresh_bundle_table_body( table ) {
            var table = table || $('.wc-rpt-table'),
                name  = table.attr( 'data-formname' );
            var count = 0;

            table.find('tbody').find('tr').each(function(){
                var row = $(this),
					inputs = row.find(':input'),
					currentCount = row.attr('data-index');

                inputs.each(function(){
					var attr_name = $(this).attr('name');
					if ( attr_name ) {
                        attr_name = attr_name.replace(name + '[' + currentCount + ']', name + '[' + count + ']');
                        $(this).attr('name', attr_name);
                    }
				});

                row.attr('data-index', count );
                count++;
            });
        }

		$(".rpt-date-column .rpt-datepicker").datepicker({
	        dateFormat : 'dd-mm-yy',
		});
		
		$( document.body ).on( 'woocommerce_variations_loaded', function(){
			$(".rpt-date-column .rpt-datepicker").datepicker({
				dateFormat : 'dd-mm-yy',
			});
		});
	});
	

})( jQuery );
