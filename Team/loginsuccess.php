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
       


           
        <div id="page-content-wrapper">
        <?php
		//session_start();
		error_reporting(0);
		//session_start();
		extract($_POST);
		$fusername = $_POST['email'];
		$fpassword = $_POST['password'];


		$servername = "localhost";
		$username = "root";
		$password = "password";
		$dbname = "twoseventhree";
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


	
			$sql = "select * from userdetails where email = '$email' and password = '$fpassword'";
			//echo "hello world";
		    //$result = $conn->query($sql);
		    $result=mysqli_query($conn, $sql) or die(mysqli_error($conn)); 
			if ($result->num_rows >0) 
			{
				$_SESSION['login_user']=$email;
				//header("location: success.php");
				echo "welcome ".$email."";
                echo $_SESSION['login_user'];
			}
			else
			{
				echo "invalid username and password";
			}


		$conn->close();
		?>
           
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

