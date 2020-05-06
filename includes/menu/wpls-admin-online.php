<?php

	$wpls_google_api_key = get_option( 'wpls_google_api_key' );
	$wpls_refresh_time = get_option( 'wpls_refresh_time' );	
	if(!empty($wpls_refresh_time))
		{
			if($wpls_refresh_time < 5000)
				{
					$wpls_refresh_time = '5000';
				}
			else
				{
				$wpls_refresh_time = $wpls_refresh_time;
				}
			
		}
	else
		{
			$wpls_refresh_time = '5000';
		}
?>



<div class="wrap">
<h2>WP Live Statistics - Online</h2>
<div class="kento-wp-stats-admin">
    <style>
#map-canvas {
  height: 500px;
  margin: 0;
  padding: 0;
  width: 100%;
}
    </style>



<div class="onlinecount">

<span class="count"></span><br />
<span class="script"><script>var address = []; </script></span><br />

Total User Online
</div>

<div id="map-canvas" ></div>
















<script>		



	var geocoder;
	var map;


	function initialize() {

		geocoder = new google.maps.Geocoder();

		var myLatlng = new google.maps.LatLng(51.482557, -0.007670);
	
		var mapOptions = {
		zoom: 1,
		center: myLatlng
		};
		
		var map = new google.maps.Map(document.getElementById('map-canvas'),
		  mapOptions);
		  
		var i;

		for (i = 0; i < address.length; i++) { 

			geocoder.geocode( { 'address': address[i]}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
				  map.setCenter(results[0].geometry.location);
				  var marker = new google.maps.Marker({
					  map: map,
					  position: results[0].geometry.location
				  });
				} else {
					console.log('Geocode was not successful for the following reason: ' + status);
				  //alert('Geocode was not successful for the following reason: ' + status);
				}
			  });

    	}

	}
	


	
	
	function loadScript() {

	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = 'https://maps.googleapis.com/maps/api/js?key=<?php echo $wpls_google_api_key; ?>&' +
	  'callback=initialize';
	document.body.appendChild(script);
	}
	


	


	setInterval(function(){
		
		
		
		
		
		jQuery.ajax(
				{
			type: 'POST',
			url: wpls_ajax.wpls_ajaxurl,
			data: {"action": "wpls_live_cities_array"},
			success: function(data)
					{
						
						jQuery(".onlinecount .script").html(data);
						
						loadScript();
					}
				});	
	}, <?php echo $wpls_refresh_time; ?>)


	setInterval(function(){

		jQuery.ajax(
				{
			type: 'POST',
			url: wpls_ajax.wpls_ajaxurl,
			data: {"action": "wpls_ajax_online_total"},
			success: function(data)
					{
						jQuery(".onlinecount .count").html(data);
					}
				});	
	}, <?php echo $wpls_refresh_time; ?>)
				
			
</script>


<script>		
	jQuery(document).ready(function($)
		{

			setInterval(function(){
				$.ajax(
						{
					type: 'POST',
					url: wpls_ajax.wpls_ajaxurl,
					data: {"action": "wpls_visitors_page"},
					success: function(data)
							{
								$(".visitors").html(data);
							}
						});	
			}, <?php echo $wpls_refresh_time; ?>)
					});
			
</script>


<div class="visitors"></div>


</div>



</div>
