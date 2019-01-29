(function($) {
	'use strict';
	
	$('document').ready(function(){

		$('.switch-checkbox').on('change', function(e){
			var _self = $(this).closest('.bestbug-switch');
			if($(this).is(':checked')) {
				_self.find('.switch-value').val('yes');
			} else {
				_self.find('.switch-value').val('no');
			}
			$('[name="'+_self.find('.switch-value').attr('name')+'"]').trigger('change');
		});
	});
}(window.jQuery));
