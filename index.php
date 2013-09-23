<?php
	$mysqli = new mysqli('', '', '', '');

	if($mysqli->connect_errno){
		die('Error:' . $mysqli->connect_errno);
	}else{
		$mysqli->query("SET NAMES UTF8");

		$result = $mysqli->query("SELECT longitude, latitude, name FROM store_book");
		
		for($i=0; $i<$result->num_rows; $i++){
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$storeArray[$i] = $row;
		}
	}

	$mysqli->close();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0 user-scalable=no" />
		<meta charset="utf-8" />
	    <style type="text/css">
	      html { height: 100% }
	      body { height: 100%; margin: 0; padding: 0 }
	      #map_canvas { height: 100% }
	    </style>
		</style>
		<script>
			var stores = <?php echo json_encode($storeArray); ?>;
			var markers = [];

			function initialize() {

				var myLatlng = new google.maps.LatLng(22.629785, 120.327465);

				var mapOptions = {
				zoom: 12,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
				}
				
				var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);

				getStoresLocation();
				setStoresLocation(map);
			}

			function loadScript() {
				var script = document.createElement("script");
				script.type = "text/javascript";
				script.src = "http://maps.googleapis.com/maps/api/js?key=AIzaSyD7PjwP1DPgdLvk12Nn1UMa-XVnd4FQ8pc&sensor=false&callback=initialize";
				document.body.appendChild(script);
			}

			function getStoresLocation(){
				for(var i=0; i<stores.length; i++){
					var marker = new google.maps.Marker({
						position: new google.maps.LatLng(stores[i]['longitude'], stores[i]['latitude']),
						title: stores[i]['name']
					});

					markers.push(marker);
					
					alert(markers[i]);
				}
			}

			function setStoresLocation(map){
				for(var i=0; i<markers.length; i++){
						markers[i].setMap(map);
				}
			}

			window.onload = loadScript;
		</script>
	</head>
	<body>
		<div id="map_canvas"></div>
	</body>
</html>