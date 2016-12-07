<?php 
  session_start();
?>
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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="index.html">
                        Uber Lyft Trip Planner
                    </a>
                </li>
                <li>
                    <a href="index.html">Home</a>
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
       


           
<div id="page-content-wrapper">
<div class="container">
 <div id="signupbox" style="margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-title">Sign Up</div>
                            
                        </div> 

                        <div style="padding-top:50px"  class="panel-body" >
                            <form id="signupform"  action="signupsuccess.php" method = "post"  class="form-horizontal" role="form">
                             
                                <div style="margin-bottom: 10px" class="form-group">
                                    <label for="email" style="margin-bottom: 10px" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" required= "true" style="margin-bottom: 10px" class="form-control" name="email" placeholder="Email Address">
                                    </div>
                                </div>
                                    
                                <div style="margin-bottom: 10px" class="form-group" >
                                    <label for="firstname"  class="col-md-3 control-label">First Name</label>
                                    <div class="col-md-9">
                                        <input type="text" required= "true" style="margin-bottom: 10px" class="form-control" name="firstname" placeholder="First Name">
                                    </div> 

                                </div><br>
                                <div style="margin-bottom: 10px" class="form-group" >
                                    <label for="lastname" style="margin-bottom: 10px" class="col-md-3 control-label">Last Name</label>
                                    <div class="col-md-9">
                                        <input type="text"  required= "true" style="margin-bottom: 10px" class="form-control" name="lastname" placeholder="Last Name">
                                    </div>
                                </div>
                                <div style="margin-bottom: 10px" class="form-group" >
                                    <label for="address" style="margin-bottom: 10px" class="col-md-3 control-label">Address</label>
                                    <div class="col-md-9">
                                        <input type="text" required= "true" style="margin-bottom: 10px" class="form-control" name="address" placeholder="Address">
                                    </div>
                                </div>
                                <div style="margin-bottom: 10px" class="form-group" >
                                    <label for="password" style="margin-bottom: 10px" class="col-md-3 control-label">Password</label>
                                    <div class="col-md-9">
                                        <input type="password" required= "true" style="margin-bottom: 10px" class="form-control" name="password" placeholder="Password">
                                    </div>
                                </div>
                                    
                                <div style="margin-bottom: 10px" class="form-group" >
                                    <label for="icode" style="margin-bottom: 10px" class="col-md-3 control-label">Invitation Code</label>
                                    <div class="col-md-9">
                                        <input type="text" required= "true" style="margin-bottom: 10px" class="form-control" name="icode" placeholder="">
                                    </div>
                                </div>

                                <div class="form-group" type="submit" value="Submit">
                                    <!-- Button -->                                        
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-signup" type="submit" value="Submit" action="signupsuccess.php" style="margin-bottom: 10px" type="button" class="btn btn-info"><i class="icon-hand-right"></i>  Sign Up</button>
                                        <span style="margin-left:8px;"></span> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 control">
                                        
                                            
                                        <a href="signup.php" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                            
                                        </a>
                                        </div>
                                    </div>
                                </div>              
                            </form>
                         </div>
                    </div>
</div>
</div>

           
    </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>

</html>

