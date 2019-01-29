(function($){
	var PP = {
		initPlugins: function(){

			if($.fn.popup){
				$('.pp-popup').each(function(){

					var thisOpts = $.extend({}, {
						transition: 'all 0.3s',
						blur: false,
						scrolllock: true,
						beforeopen: function(el) {
						    $(el).trigger( "popup:beforeopen" );
					  	},
						onclose: function(el) {
						    $(el).trigger( "popup:close" );
					  	}
					}, $(this).data() );

					$(this).popup(thisOpts);
				});
			}
		},
		resetForm: function(elem){
			var $form = $(elem);

			$form.find('input:text, input:password, input:file, select, textarea').val('');
		    $form.find('input:radio, input:checkbox')
		         .removeAttr('checked').removeAttr('selected');

		    $form.trigger('pp:reset-form');
		},
		init: function(){
			this.initPlugins();
		},
	};

	PP.init();



})(jQuery);

jQuery(window).load(function(){
	jQuery( ".allow_only" ).autocomplete({
	select:  function(event,ui){
		// jQuery(this).val((ui.item ? ui.item.value : ""));
	},
	change: function(event,ui){
	  jQuery(this).val((ui.item ? ui.item.value : ""));
	}
});
});
	
	
	
 	
/*jQuery('#charitable_field_in_support_element').keyup( function() {
			if( this.value.length > 2 ) {
			var charitable_field_in_support_element = jQuery("#charitable_field_in_support_element").val();
			jQuery.ajax({
				url: 'https://api.data.charitynavigator.org/v2/Organizations',
				type: 'GET',
				data: 'app_id=3d44d93b&app_key=5afdfeab76f70d3d8495f3332e073da1&pageSize=1&search=boo'+charitable_field_in_support_element,
				dataType: 'json',
				success: function(response, textStatus, jqXHR) {
					
					alert(JSON.stringify(response));
				},
				error: function(jqXHR, textStatus, errorThrown){
					alert(textStatus, errorThrown);
				}
			});
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		
  
				
			}
		});
	 */


