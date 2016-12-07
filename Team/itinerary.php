<!DOCTYPE html>
<?php
//Step1
 $trip_name = $_GET['name'];
 
 $db = mysqli_connect('localhost','root','','googlemaps')
 or die('Error connecting to MySQL server.');
 $query = "SELECT * FROM provider_estimate";
mysqli_query($db, $query) or die('Error querying database.');
$trip = mysqli_query($db, $query);
$row = mysqli_fetch_array($trip);
?>
<html lang="en">

<head>
<script>
if (sessionStorage.getItem("trip") != null) {
            var trip = sessionStorage.getItem("trip"); 
            //alert(sessionStorage.getItem("image"));
            
}


</script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Uber Lyft Trip Planner</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        Uber Lyft Trip Planner
                    </a>
                </li>
                <li>
                    <a href="#">Home</a>
                </li>
                <li>
                    <a href= "myprofile.php">My Profile</a>
                </li>
                <li>
                    <a href="signup.php">Sign Up</a>
                </li>
                <li>
                    <a href="login.php">Login</a>
                </li>
                <li>
                    <a href="planTrip.php">Plan Your Trip</a>
                </li>
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
                 <li>
                    <a href="#">Logout</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

<?php

    $con=mysqli_connect("localhost","root","","googlemaps");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$address = mysqli_query($con,"SELECT address FROM googlemaps.locations where trip_name='$trip_name' order by trip_order;");


$complete_trip = array();
$itinerary = array();
while($addr = mysqli_fetch_array($address))
{
    // echo "$addr[0]</br>";
    array_push($complete_trip,$addr[0]);
    array_push($itinerary,$addr[0]);
}

$origin = array_shift($complete_trip);
$destination = array_pop($complete_trip);
$origin = str_replace(' ','+',$origin);
$destination = str_replace(' ','+',$destination);

$waypoint = '';

for($i = 0;$i < count($complete_trip); $i++){
    $complete_trip[$i] = str_replace(' ','+',$complete_trip[$i]);
    if(count($waypoint)==0){$waypoint = 'None';}
    else{
    $waypoint = $waypoint . $complete_trip[$i];
    if($i < count($complete_trip)-1){
        $waypoint = $waypoint . "|";
    }
    }
} 
?>


<div class="container" style="padding: 40px">
    <div class="row">
         <div class="img-thumbnail col-sm-8"  style="background-color:#cfd8dc;">
         <h2>Google Map</h2>
             
    <?php
echo "<iframe
    width=100%
    height=500
    frameborder='1' style='border:0'
    
    src='https://www.google.com/maps/embed/v1/directions?key=AIzaSyA--9vUmlsek7U7NsjGFXkMwJRIc9bUdq0&origin={$origin}&destination={$destination}&waypoints={$waypoint}' allowfullscreen>
   
</iframe>"
?>
        </div>
        <div class="col-sm-4">  
              
      <div style="padding-top:10px">  
        
        
        <?php
echo "<h1>Trip Name: $trip_name</h1>";

$result = mysqli_query($con,"SELECT * FROM provider_estimate where  name='$trip_name' and uber_cost!=0  LIMIT 1;");

echo "<table  class='table table-hover'>
    <thead>
      <tr>
        <th>Provider</th>
        <th>Cost ($)</th>
        <th>Distance (m)</th>
      </tr>
    </thead>
    <tbody id= 'tblCosts'>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td> Uber </td>";
echo "<td>" . $row[3] . "</td>";
echo "<td>" . $row[5] . "</td>";
echo "</tr>";
echo "<tr>";
echo "<td> Lyft </td>";
echo "<td>" . $row[7] . "</td>";
echo "<td>" . $row[6] . "</td>";
echo "</tr>";
}
echo "</tbody>
    </table>";
mysqli_close($con);

?>
    </div>

<div style="padding-top:50px">
    <?php
    echo "<table class='table table-hover'>
    <thead>
      <tr>
        <th>Your optimized itinerary-</th>
      </tr>
    </thead>
    <tbody>";
    for($i=0;$i<count($itinerary);$i++){
        $x = $i + 1;
        echo "<tr><td>{$x}. $itinerary[$i]</td></tr>";
    }
    ?>
</div>

</div>
<?php
while ($row = mysqli_fetch_array($trip)) {
    }
?>    
    </div>

    <a type="button" id="mail" class="btn btn-success btn-block">Get this trip via email</a>

    <a type="button" id="mailOthers" class="btn btn-info btn-block">Share this trip</a>


</div>

</div>
        <!-- Page Content -->
       


           

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
function getParameterByName(name, url) {
    if (!url) {
      url = window.location.href;
    }
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

$(document).ready(function(){


var trip= window.location.href;
var name=getCookie('name');
var email=getCookie('email');
var trip_name=getParameterByName('name');
mailUrl="http://localhost/273project/Team/mail.php"
$('#mail').attr('href',mailUrl+"?trip="+trip+"&name="+name+"&email="+email+"&tripname="+trip_name);

$('#mailOthers').click(function() {

var person = prompt("Please enter email", "");

if (person != null) {
var link=mailUrl+"?trip="+trip+"&name="+" "+"&email="+person+"&tripname="+trip_name;
window.location.href = link;

}

});

//Note: Locations Service must run on locahost:5000    
 
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });


    var next = 1;
    $(".btnAnother").click(function(e){
        e.preventDefault();
      
        //var form=  $('#init_form').clone();
        //$('#init_form').append(form);

        var $form= $('form[id^="frm"]:last');

        var num = parseInt($form.prop("id").match(/\d+/g), 10 ) +1;

        var $newForm= $form.clone().prop('id', 'frm'+num );
        $form.append($newForm);
    });
    
    $('.frm_location').submit(function(e){
        e.preventDefault();

    alert('Submit');
    console.log(this);
    name=$(this).find('.name').val();
    city=$(this).find('.city').val();
    state=$(this).find('.state').val();
    zip=$(this).find('.zip').val();
    address=$(this).find('.address').val();
    console.log(name);
    console.log(city);
    console.log(state);
    console.log(zip);
    console.log(address);


    
    //$.ajax(function(){
        //method:"POST",
        //url:"http://localhost:5000/locations",
        //data:{},
        //success:function(result){

        //}

   // });

var req=JSON.stringify(  {name: name, state:state,zip:zip,city:city,address:address});

$.support.cors=true;
$.ajax({
  type:"POST",
  method:"POST",
  
  crossdomain:true,
  url: "http://localhost:5000/locations",
  dataType:"json",
  data: req
})
  .done(function( msg ) {
    alert( "Data Saved: " + msg );
  });



    });

    
});


    </script>

</body>

</html>
