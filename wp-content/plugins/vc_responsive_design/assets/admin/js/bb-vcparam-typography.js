(function($) {
	'use strict';

	function bb_typo_build_css(){
		var bb_typography_el = $('.bb-typography-value');
		if(bb_typography_el.length <= 0) {
			return;
		}

		bb_typography_el.each(function(index){

			var _self = $(this),
				bb_typo_container = _self.closest('.bb-typography');

			var bb_typo_properties = ['color', 'line-height', 'letter-spacing', 'word-spacing', 'font-size', 'font-weight', 'font-style', 'white-space', 'text-overflow', 'text-align', 'text-transform', 'text-decoration', 'background-image'];
			var bb_typo_css = ".bb_custom_" + Date.now() + "{";
			var flag = false;
			$.each(bb_typo_properties, function( index, property ) {
				var property_el = bb_typo_container.find('.bb-typo-' + property);
				if(property_el.length > 0 && property_el.val().trim() != '') {
					var property_val = property_el.val();
					if(property == 'background-image') {
						property_val = "url('" + property_val + "')";
					}
					bb_typo_css += property + ':' + property_val + '!important;';
					flag = true;
				}
			});
			bb_typo_css += '}';
			if(flag) {
				_self.val(bb_typo_css);
			} else {
				_self.val('');
			}

		});
	}

	function bb_typo_init(){
		var bb_typography_el = $('.bb-typography-value');

		if(bb_typography_el.length <= 0 || bb_typography_el.val() == '') {
			return;
		}

		bb_typography_el.each(function(index){

			var _self = $(this),
				bb_typography_value = _self.val().trim(),
				bb_typo_container = _self.closest('.bb-typography');

			if(bb_typography_value == '') {
				return;
			}

			var data_split = bb_typography_value.split(/\s*(\.[^\{]+)\s*\{\s*([^\}]+)\s*\}\s*/g);
			bb_typography_value = (data_split[2] && data_split[2].replace(/!important/ig, ""));

			var bb_typo_properties = bb_typography_value.split(/;/);

			$.each(bb_typo_properties, function( index, property_value ) {
				if(property_value == '') {
					return;
				}
				var property = property_value.split(/\:/);

				var property_el = bb_typo_container.find('.bb-typo-' + property[0]);
				if(property_el.length > 0) {
					var property_bbval = property[1].trim();
					if(property[0] == 'background-image') {
						property_bbval = property_value.replace("background-image:", "");
						property_bbval = property_bbval.replace("')", "");
						property_bbval = property_bbval.replace("url('", "");
					}
					property_el.val(property_bbval);
					if(property[0] == 'color') {
						property_el.trigger('change');
					}
				}
			});

		});
		setTimeout( bb_typo_build_css, 100);
	}

	$('document').ready(function(){

		$('.bb-color-picker').wpColorPicker({
			change: function(event, ui){
				setTimeout( bb_typo_build_css, 100);
			}
		});
		$('.bb-typography .iris-palette').on('click', function(){
			setTimeout( bb_typo_build_css, 100);
		});

		$('.bb-typography').on('keydown' , 'input', function(){
			setTimeout( bb_typo_build_css, 100);
		});
		
		$('.bb-typography').on('change' , 'select', function(){
			setTimeout( bb_typo_build_css, 100);
		});

		bb_typo_init();
		
		$('.bbbtn-typo-uploadimage').on('click', function(){
			event.preventDefault();
			
			var frame,
			_self = $(this);
			
			// If the media frame already exists, reopen it.
			if ( frame ) {
			  frame.open();
			  return;
			}

			// Create a new media frame
			frame = wp.media({
			  title: 'Choose icon image',
			  button: {
				text: 'Use this image'
			  },
			  multiple: false  // Set to true to allow multiple files to be selected
			});


			// When an image is selected in the media frame...
			frame.on( 'select', function() {

			  // Get media attachment details from the frame state
			  var attachment = frame.state().get('selection').first().toJSON();
			  // Send the attachment id to our hidden input
			  _self.closest('.row').find('.bb-typo-background-image').val( attachment.url );
			  setTimeout( bb_typo_build_css, 100);

			});

			// Finally, open the modal on click
			frame.open();
		});

	});
}(window.jQuery));
