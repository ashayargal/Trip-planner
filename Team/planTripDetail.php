<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Uber Lyft Trip Planner</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

<!--<link href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css" rel="stylesheet">
-->
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

        <!-- Page Content -->
       


            <div id="" class="" style="margin-left:15px;width:500px;">
              <div>Choose locations</div>
                  <form  id="frm1" class="frm_location init_form" style="padding-bottom:10px;padding-top:10px;">
                   
                   <div class="form-group row">
                    <label for="example-text-input" class="col-xs-2 col-form-label">Trip Name </label>
                    <div class="col-xs-10">
                        <input type="text" id="tripname"/>
                    </div>
                    </div>

                   
                    <div class="form-group row">
                    <label for="example-text-input" class="col-xs-2 col-form-label">Start   </label>
                    <div class="col-xs-10">
                  <select id="start" class="selectpicker">
                    </select>
                    </div>
                    </div>

                     <div class="form-group row">
                    <label for="example-text-input" class="col-xs-2 col-form-label">End  </label>
                    <div class="col-xs-10">
                  <select id="end" class="selectpicker">
                    </select>
                    </div>
                    </div>


                    <div class="form-group row">
                    <label for="example-text-input" class="col-xs-2 col-form-label">Others  </label>
                    <div class="col-xs-10">
                    <select id="others" class="selectpicker" multiple>
                    </select>
                    </div>
                    </div>

            </div>
        <!-- /#page-content-wrapper -->

<a id="btnSubmit"  class="btn btn-success" href="#">Submit</a>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
-->

    <!-- Menu Toggle Script -->
    <script>
$(document).ready(function(){

 //Note: Trips Service must run on locahost:5001    
   var postUrl="http://localhost:5001/trips";

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

$('#btnSubmit').click(function(){
var tripname=$('#tripname').val();
sendStart(tripname);
sendEnd(tripname);
sendOthers(tripname);

});


$.support.cors=true;
$.ajax({
  type:"GET",
  method:"GET",
  crossdomain:true,
  url: "http://localhost:5000/locations",
  dataType:"json"
})
  .done(function( json_data ) {
   
var i = 0;
for(i = 0; i < json_data.length; i++){

    var option = $("<option>");

    option.attr("value", json_data[i]["id"]);
    option.html(json_data[i]["name"]);

var option1=option.clone();
var option2=option.clone();

    $("#start").append(option);
    $("#end").append(option1);
    $("#others").append(option2);
// $(".selectpicker").selectpicker();
    
}

});

function sendStart(tripname){
var id=$( "#start" ).val();

var req=JSON.stringify(  {name: tripname, location_id:id});

$.support.cors=true;
$.ajax({
  type:"POST",
  method:"POST",
  
  crossdomain:true,
  url: postUrl,
  dataType:"json",
  data: req
})
  .done(function( msg ) {
    alert( "Data Saved: " + msg );
  });


}

function sendEnd(tripname){
var id=$( "#end" ).val();

var req=JSON.stringify(  {name: tripname, location_id:id});

$.support.cors=true;
$.ajax({
  type:"POST",
  method:"POST",
  
  crossdomain:true,
  url: postUrl,
  dataType:"json",
  data: req
})
  .done(function( msg ) {
    alert( "Data Saved: " + msg );
  });


}

function sendOthers(tripname){
var arr=$( "#others" ).val();
var i=0;
var req;
if(arr==null || arr.length==0){
    return false;
}

for(i=0;i<arr.length;i++){

req=JSON.stringify(  {name: tripname, location_id:arr[i]});

$.support.cors=true;
$.ajax({
  type:"POST",
  method:"POST",
  
  crossdomain:true,
  url: postUrl,
  dataType:"json",
  data: req
})
  .done(function( msg ) {
    alert( "Data Saved: " + msg );
  });

}

}
  });

    </script>

</body>

</html>
