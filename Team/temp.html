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
     <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="215516589799-lbip5vkti2acolf7cdfa7054l7vvajmk.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>




    <title>Uber Lyft Trip Planner</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
</head>

<body background="images/lyft1.jpg">

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
                    <a class="button btn-danger" style="color: black" href="login.php">Login</a>
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
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
       


            
        <div id="page-content-wrapper">



<div class="container">    
        <div id="loginbox" style="margin-top:150px;" class="mainbox col-md-4 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-primary" >
                    <div class="panel-heading">
                        <div class="panel-title">Sign In</div>
                        
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" action="loginsuccess.php" method = "post" class="form-horizontal" role="form">
                                    
                           
                                
                            

                                
<img src="images/google2.png" class="img-responsive">
                                
                                
                                  <div class="g-signin2 " data-onsuccess="onSignIn" data-theme="dark" style="height: 50px" align="center"></div>
                                
                          
                                <div class="form-group">
                                    <div class="col-md-12 control">
                                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                            Don't have an account! 
                                        <a href="https://accounts.google.com/signup?hl=en">
                                            Sign Up Here
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
    <script src="https://apis.google.com/js/platform.js" async defer></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>

  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

  function onSignIn(googleUser) {
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        console.log("ID: " + profile.getId()); // Don't send this directly to your server!
        console.log('Full Name: ' + profile.getName());
        console.log('Given Name: ' + profile.getGivenName());
        console.log('Family Name: ' + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());
        var img= profile.getImageUrl();
        var name1=profile.getName();
        var image1=url = img.replace(/^https:\/\//i, 'http://');

       
        var email1=profile.getEmail();
        // The ID token you need to pass to your backend:
        var id_token = googleUser.getAuthResponse().id_token;
        console.log("ID Token: " + id_token);

        $.support.cors = true;
       // $.post("http://localhost:5005/save_users")
       // .done(function(msg){ 
       //     alert('sucess');
       // });
       // .fail(function(xhr, status, error) {
       //     alert('fail');
       // });

       $.ajax({
        type: 'POST',
        url: 'http://localhost:5005/users',
        data: JSON.stringify({ 
             "name": name1, 
             "email": email1
        }),
        success: function(msg){
            if(msg=='OK'){

                setCookie('name',name1,1);
                
                sessionStorage.setItem('name', name1);
                setCookie('image',image1,1);
                sessionStorage.setItem('image', image1);
                setCookie('email',email1,1);
                sessionStorage.setItem('email', email1);
                window.location.replace("http://localhost/273project/Team/PlanTrip.php");
            }
        }
     });


      
      };

    </script>

</body>

</html>
