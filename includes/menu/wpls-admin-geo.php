<div class="wrap">
<h2>Kento WP Stats - Top Geo</h2>

<div class="button load-map" onClick="loadScript();">Load Map</div>
<div id="map-canvas" ></div>
    <style>
#map-canvas {
  height: 200px;
  margin: 0;
  padding: 0;
  width: 100%;
}
    </style>





<script>



	function initialize() {
	var mapOptions = {
	zoom: 8,
	center: new google.maps.LatLng(23.736959, 90.446105)
	};
	
	var map = new google.maps.Map(document.getElementById('map-canvas'),
	  mapOptions);
	}
	
	function loadScript() {

	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&' +
	  'callback=initialize';
	document.body.appendChild(script);
	}
	














</script>




</div>
