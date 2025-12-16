<?php
/* @license GNU General Public License, version 3
 * création @Lionel Croquefer 2019
 * Version du 7 novembre 2025
 */
$lat = $_GET['lat'];
$lon = $_GET['lon'];
$altitude = $_GET['alt'];
if ($altitude > 0) { $alt = $altitude; }
else {
$alt = "'indéterminée ou 0'";
}
$zoom = $_GET['zoom'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Mapop</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" href="leaflet/leaflet.css">
<link rel="stylesheet" href="leaflet/Control.FullScreen.css">
<style>
html, body{
width: 100vw;
height: 100%;
}
body {
padding: 0;
margin: 0;
}
#mapid {
width: 100%;
height: 100vh;
}
</style>
<script src="leaflet/leaflet.js"></script>
<script src="leaflet/Control.FullScreen.js"></script>
</head>

<body>
<div id="mapid"> </div>
<script>
const mymap = L.map('mapid',{
	fullscreenControl: true,
	fullscreenControlOptions: {
	position: 'topleft'
}}).setView([<?=$lat?>, <?=$lon?>], <?=$zoom?>);

const baselayers = {
"OpenHikingMap": L.tileLayer("https://tile.openmaps.fr/opentopomap/{z}/{x}/{y}.png", {
		maxZoom: 19,
		maxNativeZoom: 18,
		attribution: '&copy; <a href="//openmaps.fr/" target="_blank">OpenHikingMap</a> | SRTM (CC-BY-SA)'
	}),
"OpenStreetMap": L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
		maxZoom: 19,
		attribution: '&copy; <a href="//www.openstreetmap.org/copyright" target="_blank">OpenStreetMap</a>'
	}),
"Satellite" : L.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}", {
		maxZoom: 19,
		maxNativeZoom: 18,
		attribution: '&copy; <a href="//www.esri.com/fr-fr/" target="_blank">Esri</a> ArcGIS'
	})
};

let marker = L.marker([<?=$lat?>, <?=$lon?>]).addTo(mymap)
    .bindPopup('altitude = '+ <?=$alt?> +' m')
    .openPopup();

let layerControl = L.control.layers(baselayers).addTo(mymap);
baselayers.Satellite.addTo(mymap);

	// detect fullscreen toggling
	mymap.on('enterFullscreen', function(){
		if(window.console) window.console.log('enterFullscreen');
	});
	mymap.on('exitFullscreen', function(){
		if(window.console) window.console.log('exitFullscreen');
	});
</script>
</body>
</html>
