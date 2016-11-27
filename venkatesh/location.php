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
</head>
<body>
    <header>
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
    <div id="googleMap" style="height:400px;width:100%;"></div>

    <!-- Add Google Maps -->
    <!--<script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCe30oLPh7uH3vWngw96bjZ0HLPq51Byf8'></script>-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkXqoIUFG1XUbMsV2KfsW2_wxt7m0SivY"></script>
    <script>
        var myCenter = new google.maps.LatLng(12.972442, 77.580643);

        function initialize() {
            var mapProp = {
                center: myCenter,
                zoom: 12,
                scrollwheel: false,
                draggable: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);

            var marker = new google.maps.Marker({
                position: myCenter,
            });

            marker.setMap(map);
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    </script>

    <script>
        $(document).ready(function() {
            // Add smooth scrolling to all links in navbar + footer link
            $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
                // Make sure this.hash has a value before overriding default behavior
                if (this.hash !== "") {
                    // Prevent default anchor click behavior
                    event.preventDefault();

                    // Store hash
                    var hash = this.hash;

                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 900, function() {

                        // Add hash (#) to URL when done scrolling (default click behavior)
                        window.location.hash = hash;
                    });
                } // End if
            });

            $(window).scroll(function() {
                $(".slideanim").each(function() {
                    var pos = $(this).offset().top;

                    var winTop = $(window).scrollTop();
                    if (pos < winTop + 600) {
                        $(this).addClass("slide");
                    }
                });
            });
        })
    </script>
</body>
</html>