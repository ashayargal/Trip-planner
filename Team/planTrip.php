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
    <link href="css/planTrip.css" rel="stylesheet">
    <link href="css/toastr.min.css" rel="stylesheet">
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
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
 <div style="padding-left:20%;">
<form id="frmLocation" class="wd">
    <div><h2>Add Location</h2></div>
    <div class="form-group-row">
        <label class="col-xs-2 col-form-label" for="autocomplete">Type location<span class="req">*</span></label>
          
        <div class="col-xs-10">

            <input id="autocomplete" class="compulsory" placeholder="Enter your address" required onFocus="geolocate()" type="text" />
          
        </div>
    </div>
    <div class="form-group-row">
        <label class="col-xs-2 col-form-label" for="street_number">Street Number</label>
        <div class="col-xs-10">

            <input class="field" id="street_number" placeholder="Street Number" disabled>
        </div>
    </div>
    <div class="form-group-row">
        <label class="col-xs-2 col-form-label" for="route">Address Line 2</label>
        <div class="col-xs-10">

            <input class="field" id="route" placeholder="Address Line 2" disabled>
        </div>
    </div>
    <div class="form-group-row">
        <label class="col-xs-2 col-form-label" for="locality">City</label>
        <div class="col-xs-10">

            <input class="field" id="locality" placeholder="City" disabled>
        </div>
    </div>
    <div class="form-group-row">
        <label class="col-xs-2 col-form-label" for="administrative_area_level_1">State</label>
        <div class="col-xs-10">

            <input class="field" id="administrative_area_level_1" placeholder="State" disabled>
        </div>
    </div>
    <div class="form-group-row">
        <label class="col-xs-2 col-form-label" for="postal_code">Zip</label>
        <div class="col-xs-10">

            <input class="field" id="postal_code" placeholder="Zip" disabled>
        </div>
    </div>
    <div class="form-group-row">
        <label class="col-xs-2 col-form-label" for="country">Country</label>
        <div class="col-xs-10">

            <input class="field" id="country" placeholder="Country" disabled>
        </div>
    </div>
    <div class="form-group-row">
        <label class="col-xs-2 col-form-label" for="name">Name<span class="req">*</span></label>
            <div class="col-xs-10">

            <input class="field compulsory"  id="name" placeholder="Name" autocomplete="off" required>
   
        </div>
    </div>
    <button type="button" id="btnReset" class="btn btn-warning">Add Another</button>

    <button type="submit" id="btnSubmit" class="btn btn-primary">Submit</button>

    <a href="PlanTripDetail.php" id="btnNext" class="btn btn-info">Next</a>

</form>
</div>
<div id="bottom" style="padding-left:20%;">
<div id="photo" class="wd50">
<div><h2>Recent photos</h2></div>
</div>
<div id="weather" class="wd50">
    <div><h2>Weather</h2></div>
<div class="form-group-row">
        <label class="col-xs-2 col-form-label">Temperature</label>
        <div class="col-xs-10">
            <label class="col-xs-10 col-form-label" id="lblTemp"></label>
        </div>
</div>

<div class="form-group-row">
        <label class="col-xs-2 col-form-label">Humidity</label>
        <div class="col-xs-10">
            <label class="col-xs-10 col-form-label" id="lblHumidity"></label>
        </div>
</div>

<div class="form-group-row">
        <label class="col-xs-2 col-form-label">Weather Report</label>
        <div class="col-xs-10">
            <label class="col-xs-10 col-form-label" id="lblStatus"></label>
        </div>
</div>

</div>
<script src="js/jquery.js"></script>


<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script src="js/toastr.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBCZMsdz3PpfD35Z5F2HKhjIQZzv5sdeeM&libraries=places&callback=initAutocomplete"
async defer></script>

<script>
var placeSearch, autocomplete,latitude,longitude;
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
};

function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
        { types: ['geocode'] });

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();

    for (var component in componentForm) {
        document.getElementById(component).value = '';
        //document.getElementById(component).disabled = false;
    }

    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
        }
    }
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
          
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
        });
    }
}


$(document).ready(function () {
$('#bottom').hide();    
$('#frmLocation').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    //toastr.warning('Form not submitted','Enter button disallowed');
    return false;
  }
});

    function getPic(msg){
     console.log('Inside pic');
     $.support.cors = true;
        $.ajax({
            type: "POST",
            method: "POST",
            crossdomain: true,
            url: "https://maps.googleapis.com/maps/api/place/photo",
            dataType: "jsonp",
            data: {
                'max-width':400,
                'photoreference':msg,
                key:'AIzaSyDM0NDXnVwJjancQ-b1oXCLvxVC9sD3NZE'
            }
        })
          .done(function (msg) {
              console.log(msg);
              toastr.success("photo retreived","Success");
              
              //return false;
          });


    }

function jsonFlickrApi() {
  console.log(
     "Got response from Flickr-API with the following photos: %o", 
     response.photos
  );
  // Handle the response here. I.E update the DOM, trigger event handlers etc.
}

  function getPlaces(){
      console.log('Inside places');
      var keywords=$('#autocomplete').val().split(',')[0].trim();
      console.log(keywords);
      var flickrtags="architecture";
      var flickr="flickr.photos.search";
      var URL="https://api.flickr.com/services/rest/?method="+flickr+"&api_key=9291cf95b00d07f5e58dd85350de1199&format=json&";

        var params= {
            per_page:5,
            text:keywords,
            tags:flickrtags
        }

URL=URL+$.param(params)+ '&jsoncallback=?';

$.getJSON(URL,function (data) {
$('#bottom').show();

       if (data.photos.photo === undefined || data.photos.photo.length == 0) {
         $('#photo').empty();  
         toastr.error('No pictures of location found'); 
        }
        console.log(data.photos.photo[0]);
        $('#photo').empty();
        $.each(data.photos.photo, function(i, rPhoto){
         var basePhotoURL = 'https://farm' + rPhoto.farm + '.staticflickr.com/'
                + rPhoto.server + '/' + rPhoto.id + '_' + rPhoto.secret+'.jpg';
           //console.log(basePhotoURL);
            
            var img = $('<img id="dynamic">'); 
            img.attr('src', basePhotoURL);
            img.appendTo('#photo');
            img.width(500);
            return false;
        });
       
   });
  }
  
    function Reset() {
      console.log('Reset is called');
        var inputs = $("input:text");
        //location.reload();  
        inputs.val('');
        inputs[0].focus();
    }

    function submitForm(){
      
      console.log('Form is submitted');
        event.preventDefault();
        name = $('#name').val();
        city = $('#locality').val();
        state = $('#administrative_area_level_1').val();
        zip = $('#postal_code').val();
        address = $('#street_number').val() + $('#route').val();
        country=$('#country').val(); 
    

      var req = JSON.stringify({ name: name, state: state, zip: zip, city: city, address: address });
       //getPlaces();
       getWeather(city,country);
        $.support.cors = true;
        $.ajax({
 
            type: "POST",
            method: "POST",

            crossdomain: true,
            url: "http://localhost:5000/locations",
            dataType: "json",
            data: req
        })
          .done(function (msg) {
              //toastr.success("Data Saved","Success");
              //Reset();
              //return false;
              
          });

          return false;
    }

    $('#btnReset').click(function (e) {
        Reset();
        
    });

    $('#btnSubmit').click(function (e) {
        e.preventDefault();
    
      //Take care of aberrations

      if($('#country').val().length===0 && $('#administrative_area_level_1').val().length!=0){

          $('#country').val('United States');
      }

    
        if(validateForm()){
        submitForm();
        }
    });



$('.compulsory').blur(function()
{
    if( !$(this).val() ) {
          $(this).addClass('warning');
    }
});



function getWeather(city,country){
  if (country=="United States"){

    country="us";
  }
  else{
    return;
  }
  $.support.cors = true;
  var url1="http://api.openweathermap.org/data/2.5/find";
  $.ajax({
  crossdomain: true,
   method: 'GET',
  url: url1,
  headers: {
        'Content-Type': 'application/json',
    },
  dataType: "jsonp",
  data: {
    APPID:'e978172084c5f9235c421760880d0e00',
    q:city+","+country,
    units:'imperial'
    
  },
  error:function(){
      toastr.error('API call timed out');

  }
  }).done(function (msg) {
              console.log('Get weather called');
              toastr.success('Current temperature is '+ msg.list[0].main.temp + ' F',  "Temperature");
              //toastr.success('Current humidity is '+ msg.list[0].main.humidity + ' %',  "Humidity");
               //toastr.success('Weather Report: '+ msg.list[0].weather[0].description + ' expected',  "weather Report");
               
               $('#lblTemp').text(msg.list[0].main.temp + ' F');
               $('#lblHumidity').text(msg.list[0].main.humidity + ' %');
               
               $('#lblStatus').text('Expected '+msg.list[0].weather[0].description);
               
               console.log(msg);
               console.log(msg.list[0]);
               console.log(msg.list[0].main.temp); 

               latitude=msg.list[0].coord.lat;
               longitude=msg.list[0].coord.lon;
               getPlaces();
              return false;
          });


}
    function validateForm(){
      var address=$("#autocomplete");
      var name=$('#name');
      var country=$('#country');
      var city=$('#locality');
      var zip=$('#postal_code');
      var state=$('#administrative_area_level_1');

      
      if(address.val().length===0 || name.val().length===0 ||country.val().length===0  ){
        toastr.error('Location not validated !', 'Please fill all details');
        return false;
      }
        toastr.success('Location validated !', 'From Google');
        //getWeather(city);
        return true;
    }

});

</script>


</body>

</html>
