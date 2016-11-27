<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Uber Lyft</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/5.0.0/bootstrap-social.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
    <nav class="navbar navbar-dark bg-inverse">
     <div class="nav navbar-nav container">
            <a class="navbar-brand" href="index.php">
                Uber Lyft
            </a>            
            <a class="nav-item nav-link active ml-2" href="index.php">Home <span class="sr-only">(current)</span></a>
            
            <a class="nav-item nav-link float-lg-right" href="login.php">Login</a>
            <a class="nav-item nav-link float-lg-right" href="signup.php">Sign Up</a>
  <!-- Navbar content -->
</nav>

    </header>

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


	
	$sql = "select * from userdetails where email = '$email'";
	//echo "hello world";
    //$result = $conn->query($sql);
    $result=mysqli_query($conn, $sql) or die(mysqli_error($conn)); 
	if ($result->num_rows >0) 
	{
		$_SESSION['login_user']=$email;
		//header("location: success.php");
		echo "welcome ".$email."";
	}
	else
	{
		echo "invalid username and password";
	}


$conn->close();
?>

</body>
</html>