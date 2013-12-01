<?php
	echo "<h2>Send stuff to LA Bikemap</h2>";
?>

<html>
<head>
<link href='http://fonts.googleapis.com/css?family=Ruda' rel='stylesheet' type='text/css'>
<link href="style.css" rel="stylesheet" type="text/css" />
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
<script>
//var x=document.getElementById("demo");
//========================================================================
//	getLocation()
//========================================================================
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  }
  else{
		console.log ("Geolocation is not supported by this browser.");
	}
}

//=================================================================================
//  uploadFile()
//=================================================================================
function uploadFile(e) {
	//console.log( e );
  console.log( document.getElementById('upload-file').value	 );
}

function submitForm(e) {
	  console.log( document.getElementById('upload-file').value	 );
	
}

//========================================================================
//	showPosition (position)
//========================================================================
function showPosition(position)  {
	var lat 		= position.coords.latitude;
	var lon 		= position.coords.longitude;
	var coords 	= lat+","+lon;

  var readout = "Latitude: " + lat + "<br>Longitude: " + lon;

	console.log(coords);
	console.log(readout);
	document.getElementById('coords').innerHTML = readout;
}

//========================================================================
//	showError (error)
//========================================================================
function showError(error) {
  switch(error.code) {
    case error.PERMISSION_DENIED:
      document.getElementById('coords').innerHTML ="User denied the request for Geolocation."
      break;
    case error.POSITION_UNAVAILABLE:
      document.getElementById('coords').innerHTML ="Location information is unavailable."
      break;
    case error.TIMEOUT:
      document.getElementById('coords').innerHTML ="The request to get user location timed out."
      break;
    case error.UNKNOWN_ERROR:
      document.getElementById('coords').innerHTML ="An unknown error occurred."
      break;
 	}
}

/* GOOGLE MAPS API V3 START ============================================================== */
var map;
    
function initialize() {
  var mapOptions = {
    zoom: 15,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  // Try HTML5 geolocation
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(position.coords.latitude,
                                       position.coords.longitude);

      var infowindow = new google.maps.InfoWindow({
        map: map,
        position: pos,
        content:'<div id="nfo-window" style="width: auto; height: auto; color: #333; font-size:16px; font-family:Ruda">We think this may be you...</div>'
      });
     

      map.setCenter(pos);
    }, function() {
      handleNoGeolocation(true);
    });
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }
}

//=================================================================================
//  handleNoGeolocation (errorFlag)
//=================================================================================
function handleNoGeolocation(errorFlag) {
  if (errorFlag) {
    var content = 'Error: The Geolocation service failed.';
  } else {
    var content = 'Error: Your browser doesn\'t support geolocation.';
  }

  var options = {
    map: map,
    position: new google.maps.LatLng(60, 105),
    content: content
  };
  
  //var infowindow = new google.maps.InfoWindow(options);
  //infowindow.setOptions({ maxWidth: 560 }); 
  map.setCenter(options.position);
}

google.maps.event.addDomListener(window, 'load', initialize);
/*  GOOGLE MAPS API v3.0 END ======================================================================= */
    
</script>

<style>  
  body { padding: 30px; }
  input, select {
    font-family: 'Ruda', sans-serif; font-size: 20px; color: #fff;  font-weight: 300;
    border: 1px solid #000; background-color: #333;
    line-height: 1.2; padding: 10px; padding-left: 14px;
    border-radius: 4px;  width: 240px;
  }
  
  submit, button {
    font-family: 'Ruda', sans-serif; font-size: 20px; color: #fff;  font-weight: 300;
    border: 1px solid #000; background-color: #0066FF;
    line-height: 1.2; padding: 10px; padding-left: 14px;
    border-radius: 4px;  width: 240px;
  }
  
  #map-canvas {
      height: 220px; width: auto;  margin: 0px;  padding: 0px; border: 1px solid #000;
      border-radius: 4px; overflow: hidden;
  }
    
/*
    #nfo-window {
      position: absolute;
      z-index: 999; 
      width: 400px; height: 100px;
      display: none;
      background-color: #fff;
      border: 1px solid #ebebeb;
      padding: 10px;
   }
*/
  </style>

</head>

<button onclick="getLocation()">Display Lat/Lon</button>
<div id="map-canvas"></div>
<div id="coords"></div>
<input placeholder="Your Name" size="22"></input>

<br>
   <h2>Place</h2>
    <select id = "myList">
      <option value = "1">Co-working Space</option>
               <option value = "2">Food joint</option>
               <option value = "3">Local Bar</option>
               <option value = "4">Solid Bike Parking</option>
             </select>

<h2>Media Upload</h2>
<input type="file" name="upload-file" id="upload-file" onchange="uploadFile(this);" style="width: 480px">
<hr>
<button type="submit" id="submit" onClick="submitForm(this);">Post it!</button>
</html>
