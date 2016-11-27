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
	<!-- Carousel Starts here -->

	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
	  <ol class="carousel-indicators">
	    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
	    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
	    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
	  </ol>
	  <div class="carousel-inner" role="listbox">
	    <div class="carousel-item active" style="width: 1350px; height:500px">
	      <img src="images/uber.jpg" alt="First slide" class="carousel-images">
	      <div class="carousel-caption mb-1">
		    <h3>Uber</h3>
		    <p>Want to take a ride</p>
			<button type="button" class="btn btn-outline-secondary">Explore</button>
		  </div>
	    </div>
	    <div class="carousel-item" style="width: 1350px; height:500px">
	      <img src="images/lyft.jpg" alt="Second slide" class="carousel-images">
	      <div class="carousel-caption mb-1">
		    <h3>Lyft</h3>
		    <p>Looking for ride</p>
			<button type="button" class="btn btn-outline-secondary">Explore</button>
		  </div>
	    </div>
	    <div class="carousel-item" style="width: 1350px; height:500px">
	      <img src="images/uberlyft.jpg" alt="Second slide" class="carousel-images">
	      <div class="carousel-caption mb-1">
		    <h3>Uber vs Lyft</h3>
		    <p>Want to take Cheap ride</p>
			<button type="button" class="btn btn-outline-secondary">Explore</button>
		  </div>
	    </div>
	  </div>
	  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
	    <span class="icon-prev" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
	    <span class="icon-next" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	  </a>
	</div>
	<!-- End of Carousel -->


	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js"></script>	
</body>
</html>