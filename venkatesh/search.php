<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Uber Lyft</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.0.0/bootstrap-social.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
 <style>
       #map {
        height: 400px;
        width: 100%;
       }
    </style>
</head>

    <header>
    <body>
    <nav class="navbar navbar-dark bg-inverse">
     <div class="nav navbar-nav container">
            <a class="navbar-brand" href="index.php">
                Uber Lyft
            </a>            
            <a class="nav-item nav-link active ml-2" href="index.php">Home <span class="sr-only">(current)</span></a>
          
            <a class="nav-item nav-link float-lg-right" href="login.php">Login</a>
            <a class="nav-item nav-link float-lg-right" href="signup.php">Sign Up</a>
  <!-- Navbar content -->
</nav>

    </header>
  <body onload="initialize()">
  <div class="container">    
  <div class="controls-row row">
 
  <form id="searchform" class="form-horizontal" role="form">
  
                             
                                <div style="margin-bottom: 50px" class="form-group">
                                    <label for="start" style="margin-bottom: 10px, margin-top: 50px" class="col-md-1 control-label">Start</label>
                                    <div class="col-md-4">
                                        <input type="text" id="start" style="margin-bottom: 50px" class="form-control" name="start" placeholder="Start Location">
                                    </div>
                                </div>
                                
                                    
                                <div style="margin-bottom: 50px, margin-top: 50px" class="form-group" >
                                    <label for="destination"  class="col-md-1 control-label">Destination</label>
                                    <div class="col-md-4">
                                        <input type="text" id= "destination"  style="margin-bottom: 50px" class="form-control" name="destination" placeholder="Destination">
                                    </div> 

                                </div>
                                <div class="form-group" type="submit" value="Submit">
                                                                          
                                    <div class="col-md-offset-3 col-md-2">
                                        <button id="btn-search" type="submit" value="Submit" onclick="codeAddress()"  style="margin-bottom: 10px" type="button" class="btn btn-info"><i class="icon-hand-right"></i>  Search</button>
                                        <span style="margin-left:8px;"></span> 
                                    </div>
                                </div>  
                            </form>
                            <br>
                            <br>
                                </div>
                                </div>
    <div id="map"></div>
    <script>
    var geocode;
    var  map;
    var uluru = {lat: -25.363, lng: 131.044};
      function initMap() {
        
         map = new google.maps.Map(document.getElementById('map'), {
          zoom: 4,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map,
          draggable:true
        });
      }
      function initialize() {
      geocoder = new google.maps.Geocoder();
      var latlng = new google.maps.LatLng(-34.397, 150.644);
      var mapOptions = {
      zoom: 8,
      center: latlng
      }
      map = new google.maps.Map(document.getElementById('map'), mapOptions);
      }

      function addMarker() { 
      
          var marker = new google.maps.Marker({
          position: uluru,
          map: map,
          draggable:true
        });
      

      }
      function search(){ 
      
          var marker = new google.maps.Marker({
          position: uluru,
          map: map,
          draggable:true
        });
      }

      function codeAddress()
      {
        codeAddress1();
        codeAddress2();
      }
      function codeAddress1() {
         
    var address = document.getElementById('start').value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == 'OK') {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }
   function codeAddress2() {
    var address = document.getElementById('destination').value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == 'OK') {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkXqoIUFG1XUbMsV2KfsW2_wxt7m0SivY&callback=initMap">
    </script>

    <button onclick="addMarker()">Click here</button>
  </body>
</html>