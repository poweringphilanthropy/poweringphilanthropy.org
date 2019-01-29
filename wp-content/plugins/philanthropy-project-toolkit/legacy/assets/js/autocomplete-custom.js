jQuery(window).load(function(){
	var thiss = "";
	jQuery('#charitable_field_in_support_element').devbridgeAutocomplete({
	serviceUrl: 'https://api.data.charitynavigator.org/v2/Organizations?app_id=3d44d93b&app_key=5afdfeab76f70d3d8495f3332e073da1',
	paramName: 'search',
	autoSelectFirst :false,
	triggerSelectOnValidInput :false,
	onSearchStart : function(param){
		thiss = jQuery(this);
		param.search = encodeURIComponent(param.search);
		jQuery(this).addClass('loading');
		return param;
	},
	ajaxSettings : function(){
		headers : {Accept :	'*/*'}
	},
	onSearchComplete : function(){
		jQuery(this).removeClass('loading');
	},
    transformResult: function(response) {
        return {
            suggestions: jQuery.map(JSON.parse(response), function(dataItem) {
				var str2 = thiss.val();
				var str1 = dataItem.charityName;
				if(str1.toLowerCase().indexOf(str2.toLowerCase()) != -1){
					return { value: dataItem.charityName, data: dataItem.ein };
				}
            })
        };
    },
	onSelect: function (suggestion) {
		//console.log()
		
		jQuery('input[name="charitable_tax_id"]').val(suggestion.data);
    }
	});

});