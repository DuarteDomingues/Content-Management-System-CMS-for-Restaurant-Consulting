

<!DOCTYPE html>
<html>
  <head>
    <title>Add Map</title>

    <style type="text/css">
      /* Set the size of the div element that contains the map */
      #map {
        height: 400px;
        /* The height is 400 pixels */
        width: 100%;
        /* The width is the width of the web page */
      }
    </style>
    <script>
      // Initialize and add the map
      function initMap() {
        // The location of Uluru
        const uluru = { lat: 38.8315, lng: -9.1741 };
        // The map, centered at Uluru
        const map = new google.maps.Map(document.getElementById("map"), {
          zoom: 10,
          center: uluru,
        });
        // The marker, positioned at Uluru
        
        
        var marker;

        google.maps.event.addListener(map, 'click', function(event) {
         placeMarker(event.latLng);
         //alert(event.latLng);
         var myLatLng = event.latLng;
         var lat = myLatLng.lat();
         var lng = myLatLng.lng();
         
         document.getElementById("lat").value =lat;
         document.getElementById("log").value =lng;
         GetAddress();
        });


    function placeMarker(location) {

    if (marker == null)
    {
          marker = new google.maps.Marker({
             position: location,
             map: map
          }); 
    } 
    else 
    {
        marker.setPosition(location); 
    } 
    }
   
        
      }

    </script>
  </head>
  <body>
       <form method="POST" id="signup-form" name="myform" class="signup-form">
    <h3>My Google Maps Demo</h3>
    <!--The div element for the map -->
    <div id="map"></div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgAJ_p2Q0c8cwyZZ98HMEojf9g0uakFDk&callback=initMap&libraries=&v=weekly"
      async
    ></script>
  
    <script type="text/javascript">
        function GetAddress() {
            var lat = parseFloat(document.getElementById("lat").value);
            var lng = parseFloat(document.getElementById("log").value);
            var latlng = new google.maps.LatLng(lat, lng);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
                        alert("Location 1: " + results[1].formatted_address);
                        var res = results[1].formatted_address.split(",");
                        
                        
                        var a= res[1].substring(1);
                        a= a.split(" ");
                        //console.log(res[0]);
                        
                        var address = res[0];
                        var city = "";
                        var i=0;
                        a.forEach(function(item, index, array) {
                            if (i===0){
                                address = address + " " + item;
                            }else{
                                city=city + " " +item;
                            }
                            //console.log(item);
                            i++;
                        })
                        console.log(address);
                        city= city.substring(1);
                        console.log(city);
                        //console.log(a[2]);
                        
                         document.getElementById("add").value =address;
                         document.getElementById("city").value =city;
                        
                    }
                     
                }
            });
        }
        
    </script>
    <input type="button" value="Get Address" onclick="GetAddress()" />
    
     <div><input type="hidden" name="lat" id= "lat" value=""></div>
     
      <div><input type="hidden" name="log" id= "log" value=""></div>
      
       <div><input type="hidden" name="add" id= "add" value=""></div>
      
      <div><input type="hidden" name="city" id= "city" value=""></div>
     
     
    
     <div class="form-group">
     <input type="submit" name="submit" id="submit"  class="form-submit" value="Add" />
     </div>
    
       </form>
  </body>
</html>

<?php

  
    if(isset($_POST["submit"])){
        
        $lat = $_POST['lat'];
        $log = $_POST['log'];
        $add = $_POST['add'];
        $city = $_POST['city'];
        
        echo ($lat);
        echo ("<br>");
        echo ($log);
        echo ("<br>");
        echo ($add);
        echo ("<br>");
        echo ($city);
        
    }

?>
