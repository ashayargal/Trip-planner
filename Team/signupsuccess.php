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

        <?php
        //session_start();
        error_reporting(0);
        //session_start();
        extract($_POST);
        $icode = $_POST['icode'];
        $password1 = $_POST['password'];
        $address = $_POST['address'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];

        $servername = "localhost";
        $username = "root";
        $password = "password";
        $dbname = "twoseventhree";

       
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 


            $sql = "INSERT INTO userdetails (email, firstname, lastname, password, invitationcode, address) VALUES ('$email', '$firstname', '$lastname','$password1', '$icode', '$address')";

            if ($conn->query($sql) === TRUE) 
            {
                $_SESSION['login_user']=$firstname;
                echo '<div align="center">';
                echo "New record created successfully";
                echo '</div>';
            }
            else
            {
                echo "Username already exists, try different user name";
            }


        $conn->close();
        ?>

           
        </div>

    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>




