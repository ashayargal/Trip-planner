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
<div class="container">
 <div id="signupbox" style="margin-top:50px, width:100px; height:100px;  position:absolute; left:50%; top:50%;right:50%; margin:-100px 100px 0 -200px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Sign Up</div>
                            
                        </div> 

                        <div style="padding-top:20px"  class="panel-body" >
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
                                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                            
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



 <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js"></script> 
</body>
</html>