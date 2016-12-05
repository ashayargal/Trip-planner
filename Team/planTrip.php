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
              <span>Add location</span>
            <button type="button" onclick="window.location.href='planTripDetail.php'" class="btn btn-success" style="margin-left:-88px;margin-bottom:100px;">Next >> </button>
            
            <form  id="frm1" class="frm_location init_form" style="padding-bottom:10px;padding-top:10px;">
            <div class="form-group row">
  <label for="example-text-input" class="col-xs-2 col-form-label">Name</label>
  <div class="col-xs-10">
    <input class="form-control name" type="text" value="" name="name" >
  </div>
</div>
<div class="form-group row">
  <label for="example-search-input" class="col-xs-2 col-form-label">Address</label>
  <div class="col-xs-10">
    <input class="form-control address" type="text" value="" name="address" >
  </div>
</div>
<div class="form-group row">
  <label for="example-email-input" class="col-xs-2 col-form-label">City</label>
  <div class="col-xs-10">
    <input class="form-control city" type="text" value="" name="city" >
  </div>
</div>
<div class="form-group row">
  <label for="example-url-input" class="col-xs-2 col-form-label">State</label>
  <div class="col-xs-10">
    <input class="form-control state" type="text" value="" name="state" >
  </div>
</div>
<div class="form-group row">
  <label for="example-tel-input" class="col-xs-2 col-form-label">Zip</label>
  <div class="col-xs-10">
    <input class="form-control zip" type="zip" value=""  name="zip">
  </div>
</div>
<button type="submit" class="btn btn-primary">Save</button>

            
            </form>
           <button type="button" class="btn btn-secondary btnAnother">Add Another</button>


            </div>
        <div id="new_form">
           
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>

$(document).ready(function(){

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
