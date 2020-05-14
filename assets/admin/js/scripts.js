jQuery(document).ready(function($)
	{


		
		$(document).on('click', '.filter-submit', function()
			{
				
				var filter_for = $('.filter-for').val();
				var max_items = $('.max-items').val();				
				var first_date = $('.first-date').val();				
				var second_date = $('.second-date').val();				
				
				
				
				$.ajax(
					{
				type: 'POST',
				url: wpls_ajax.wpls_ajaxurl,
				data: {"action": "wpls_top_filter",'filter_for':filter_for,'max_items':max_items,'first_date':first_date,'second_date':second_date},
				success: function(data)
						{
							$('.filter-result').html(data);
						}
					});
				
				
				})






	$('a').bind('click', function(event) {
		
		//document.cookie="wpls_landing=0; path=/";
		
			//var wpls_online_count = -1;
			$.ajax(
				{
			type: 'POST',
			url: wpls_ajax.wpls_ajaxurl,
			data: {"action": "wpls_offline_visitors"},
			success: function(data)
					{
						
					}
				});	    
		 //event.preventDefault();
		 //event.stopPropagation();
	});




	$(window).bind('beforeunload', function(){
		
		
		
		//document.cookie="wpls_landing=0; path=/";
		
			//var wpls_online_count = -1;
			$.ajax(
				{
			type: 'POST',
			url: wpls_ajax.wpls_ajaxurl,
			data: {"action": "wpls_offline_visitors"},
			success: function(data)
					{
						
					}
		});	
			  
	});





		
		
		
		
	
});