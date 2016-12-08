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
    <link href="css/toastr.min.css" rel="stylesheet">
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
                    <a href="about.php">About</a>
                </li>
                <li>
                    <a href="services.php">Services</a>
                </li>
                <li>
                    <a href="contact.php">Contact</a>
                </li>
                 <li>
                    <a href="logout.php">Logout</a>
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
<a id="btnNext" class="btn btn-info">Next</a>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/toastr.min.js"></script>

    <script src="js/spin.min.js"></script>
    <script src="js/jquery.blockUI.js"></script>
    
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
-->

    <!-- Menu Toggle Script -->
    <script>
$(document).ready(function(){
var opts = {
  lines: 15 // The number of lines to draw
, length: 52 // The length of each line
, width: 24 // The line thickness
, radius: 75 // The radius of the inner circle
, scale: 1 // Scales overall size of the spinner
, corners: 1 // Corner roundness (0..1)
, color: '#000' // #rgb or #rrggbb or array of colors
, opacity: 0.25 // Opacity of the lines
, rotate: 0 // The rotation offset
, direction: 1 // 1: clockwise, -1: counterclockwise
, speed: 1 // Rounds per second
, trail: 60 // Afterglow percentage
, fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
, zIndex: 2e9 // The z-index (defaults to 2000000000)
, className: 'spinner' // The CSS class to assign to the spinner
, top: '50%' // Top position relative to parent
, left: '50%' // Left position relative to parent
, shadow: true // Whether to render a shadow
, hwaccel: true // Whether to use hardware acceleration
, position: 'absolute' // Element positioning
};

var target = document.getElementById('frm1');
var spinner = new Spinner(opts);


 //Note: Trips Service must run on locahost:5001    
   var postUrl="http://localhost:5001/trips";

    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

$('#btnSubmit').click(function(){

$.blockUI({ message: "Please wait.....", overlayCSS: { backgroundColor: '#ddd' } });
spinner.spin(target);

var tripname=$('#tripname').val();
$.when(sendStart(tripname),sendEnd(tripname),sendOthers(tripname)).done(function(){
    getCost();
});
//sendStart(tripname);
//sendEnd(tripname);
//sendOthers(tripname);

});

function getCost(){
//alert('Get cost');
var tripname=$('#tripname').val();
sendTripName(tripname);

}


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


$('#btnNext').click(function(){
var tripname=$('#tripname').val();

function myJavascriptFunction() { 
  var javascriptVariable = tripname;
  window.location.href = "itinerary.php?name=" + javascriptVariable; 
}
myJavascriptFunction();

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
   // alert( "Data Saved: " + msg );
  });


}

function sendTripName(tripname){

var req=JSON.stringify(  {name: tripname});

$.support.cors=true;
$.ajax({
  type:"POST",
  method:"POST",
  crossdomain:true,
  url: "http://localhost:5002/trips",
  dataType:"json",
  data: req
})
  .done(function( msg ) {
   // alert('Success');
    spinner.stop();
    $.unblockUI();
    toastr.success("Database populated with costs","Route optimized" );
   
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
   // alert( "Data Saved: " + msg );
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
    //if(i==arr.length){
    
    //}
  });

}

}
  });

    </script>

</body>

</html>
