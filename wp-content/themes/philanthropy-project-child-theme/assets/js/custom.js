jQuery(document).ready(function(){
    var result = jQuery("#charitable_field_goal").hasClass("even");
    //alert(result);
    if(result == true){
     
        jQuery("#charitable_field_goal").removeClass("even").addClass("odd");
    }else{
       
    }
	
	var result = jQuery("#charitable_field_end_date").hasClass("odd");
   // alert(result);
    if(result == true){
     
        jQuery("#charitable_field_end_date").removeClass("odd").addClass("even");
    }else{
       
    }
	
	jQuery('.subject-list').on('change', function() {

		jQuery('.subject-list').not(this).prop('checked', false);  

	});
	
	jQuery(document).on("click",".load_more_donor", function(){
		var thiss = jQuery(this);
		var id = jQuery(this).attr('rel');
		var paged = jQuery(this).attr('data-paged');
		jQuery.ajax({
			type : 'post',
			url:edd_scripts.ajaxurl,
			data: {action : 'load_more_donors' , campaign_id : id , paged : paged},
			dataType : 'json',
			success : function(res){
				if(res.status){
					jQuery("ol.donors-list").append(res.html);
					thiss.attr('data-paged' , res.paged);
					if(!res.load_more){
						thiss.hide();
					}
				}
			}
		});
	})
});
