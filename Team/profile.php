<?php
    //session_start();
    //error_reporting(0);
    //session_start();
    //extract($_POST);
    //$fusername = $_POST['email'];
    //$fpassword = $_POST['password'];


    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $dbname = "googlemaps1";
//    $email = $_SESSION['login_user'];
    $name = sessionStorage.getItem('name');
    $image = sessionStorage.getItem('image');
    $email = sessionStorage.getItem('email');
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


  
      $sql = "select * from users where email = '$email'";
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
