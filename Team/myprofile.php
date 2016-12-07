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
       



        <br><br>
<div class="container-fluid well span6" style= "width: 50%;">
  <div class="row-fluid" style= "width: 600px;">
        <div class="span2" style="width:200px; float:left;"> 
        <div id="profile" class="img-circle"></div>
        </div>
        
        <div class="span8" style="width:300px; float:right;">
            <h3>Profile</h3>

            <h6><b>Email: </b><span id="email"></span></h6>
            <h6><b>Full Name:</b> <span id="name"></span></h6>
            
            
        </div>
       
</div>
</div>
</div>
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>


<script>



var img = $('<img id="profilePic">'); 
            //alert(sessionStorage.getItem("image"));
            img.attr('src', sessionStorage.getItem("image"));
            img.appendTo('#profile');
            img.css({
            'width' : '100%',
            'height' : '100%'
            });

var email=sessionStorage.getItem('email');
var name=sessionStorage.getItem('name');
console.log(email);
console.log(name);

$(document).ready(function(){

$('#name').text(name);
$('#email').text(email);
});


</script>
    <!-- Menu Toggle Script -->
</body>
</html>
