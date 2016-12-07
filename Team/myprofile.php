<?php
    session_start();
    error_reporting(0);
    //session_start();
    //extract($_POST);
    //$fusername = $_POST['email'];
    //$fpassword = $_POST['password'];


    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "googlemaps";
    $email = $_SESSION['login_user'];
    //echo "hello";
    //echo $fusername;

    //$servername = "localhost";
    //$username = "venkateshds";
    //$password = "password";
    //$dbname = "websiteuser123";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 


  
      $sql = "select * from userdetails where email = '$email'";
     // echo "hello world";
      //echo "email";
      //echo "venkateshdsmudg";
      //echo $_SESSION['login_user'];
        //$result = $conn->query($sql);
        $result=mysqli_query($conn, $sql) or die(mysqli_error($conn)); 
      if ($result->num_rows >0) 
      {
        //$_SESSION['login_user']=$email;
         $row = $result->fetch_assoc();
        //header("location: success.php");
        //echo "welcome ".$email."";
      }
      else
      {
        echo "invalid username and password";
      }


    $conn->close();
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
                    <a href="#">Plan Your Trip</a>
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
       


            
        <div id="page-content-wrapper">
        <div class="container">
      <div class="row">
      <div class="col-md-5  toppad  pull-right col-md-offset-3 ">
           <!--<A href="edit.html" >Edit Profile</A>

        <A href="edit.html" >Logout</A>
       <br>
<p class=" text-info">May 05,2014,03:00 pm </p>-->
      </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >
   
   
          <div class="panel panel-info" style = "margin-top: 50px">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo $row[firstname] ?><?php echo $row[lastname] ?></h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="<?php echo $row[image] ?>" class="img-circle img-responsive"> </div>
                
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Email:</td>
                        <td><?php echo $row[email] ?></td>
                      </tr>
                      <tr>
                        <td>First Name:</td>
                        <td><?php echo $row[firstname] ?></td>
                      </tr>
                      <tr>
                        <td>Last Name</td>
                        <td><?php echo $row[lastname] ?></td>
                      </tr>
                   
                         <tr>
                            
                        <td>Address</td>
                        <td><?php echo $row[address] ?></td>
                      </tr>
                        
                           
                     
                     
                    </tbody>
                  </table>
                  
                 
                </div>
              </div>
            </div>
                 <div class="panel-footer">
                        <!--<a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
                        <span class="pull-right">
                            <a href="edit.html" data-original-title="Edit this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>
                            <a data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
                        </span>-->
                    </div>
            
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

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

</body>

</html>

