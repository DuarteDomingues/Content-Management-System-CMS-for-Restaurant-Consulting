<?php

session_start();

$homeLink = "TemplateLogIn.php";


include 'getuserInfo.php';

$homeLink = "TemplateLogIn.php";

$login = 0;
$userName = "";
$userType = 0;


require_once( "../Lib/lib.php" );
require_once( "../Lib/db.php" );
require_once( "getUserInfo.php" );



    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );

 if (session_status() == PHP_SESSION_ACTIVE){
        if( isset($_SESSION['userId']) && !empty($_SESSION['userId'])){
            $login = 1; 
            $homeLink = "user.php";
            $userName = $_SESSION['name'];
            $id = $_SESSION['userId'];
            $userType = getUserAuthRole($id);
                
      }
 }

 $login_logout_str ="";
 
 if ($login ==0){
      $login_logout_str = "Login";

 }
 else{
      $login_logout_str = "Logout";

 }
 
 
   if( isset($_POST["submitLogoutForm"])){
      
      session_destroy();
      header("Location: http://localhost/examples-smi/Projecto/index.php");
      exit();
      
      
  }

 
 
 
 
 
?>


<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Add Restaurant</title>
        <style type="text/css">
            
            
      /* Set the size of the div element that contains the map */
      #map {
        height: 400px;
        /* The height is 400 pixels */
        width: 100%;
        /* The width is the width of the web page */
      }
    </style>
      <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="assets/img/icon.png" rel="icon">
           
  
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,600,600i,700,700i|Satisfy|Comic+Neue:300,300i,400,400i,700,700i" rel="stylesheet">
        
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
        <script src="scripts/main.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <link href="Img/favicon.png" rel="icon">
        <link href="Img/apple-touch-icon.png" rel="apple-touch-icon">
        
        <script type='text/javascript'>
            
            
        $(document).ready(function() {
            var max_fields = 10;
            var wrapper = $(".container1");
            var add_button = $(".add_form_field");

            var x = 1;
            $(add_button).click(function(e) {
                e.preventDefault();
                if (x < max_fields) {
                x++;
                $(wrapper).append('<p><div><input type="text" name="myname'+x+'"  class="selectStuff" placeholder="food '+x+'" required/><small>aa</small><input  class="selectStuff" type="number" name="myprice'+x+'" placeholder="price '+x+'" required/><small>aa</small><input  class="selectStuff" type="text" name="mydes'+x+'" placeholder="descrip '+x+'" required/><a href="#" class="delete">&nbsp;Delete</a></div><p>'); //add input box
                 document.getElementById("test").value = x;
            } else {
            alert('You Reached the limits');
            }
            });

        $(wrapper).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
        document.getElementById("test").value = x;
        })
        });
        
        ////////////////////////////////////////////////////////////////////////////
        
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
    
      <link rel="stylesheet" href="assets/css/user.css">

        
    </head>
    <body>
        
          <!-- ======= Top Bar ======= -->
  <section id="topbar" class="d-none d-lg-flex align-items-center fixed-top ">
    <div class="container text-right">
      <i class="icofont-phone"></i> +1 5589 55488 55
      <i class="icofont-clock-time icofont-rotate-180"></i> Mon-Sat: 11:00 AM - 23:00 PM
    </div>
  </section>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex align-items-center">

      <div class="logo mr-auto">
        <h1 class="text-light"><a href="index.php"><span>ChuckYummy</span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li ><a href="index.php">Home</a></li>
          <li><a href="about.php">About</a></li>

         <?php  
          if ($userType == 2){
              
              ?>
                <li class="active"><a href="user.php">Profile</a></li>
              <?php
          }
          
          else if ($userType == 3){
              
              ?>
                <li  ><a href="user.php">Profile</a></li>
                <li class="active"><a href="AddRestaurant.php">Add restaurant</a></li>
              <?php
              
          }
          
           else if ($userType == 4){
              
              ?>
                <li  ><a href="user.php">Profile</a></li>
                <li class="active"><a href="AddRestaurant.php">Add restaurant</a></li>
                <li><a href="block_users.php">Block Users</a></li>
                <li><a href="addTypes.php">Add Types</a></li>
                
                
              <?php
              
          }
          
          
          
          
          ?>
          <li class="book-a-table text-center">
              
              <?php   
              
              if ($login == 0){
                  ?>
               <a href=<?=$homeLink?>><?= $login_logout_str ?></a>

               <?php
              }
              
              else{
                
                  ?>
                 <form method="POST" id="edit_user_form" name="logoutForm" class="signup-form" >
                  <div class="form-group_2">
                 <input type="submit" id="submit" name="submitLogoutForm" type="button" class="btn btn-primary"  value="Logout"/>
                 </div>
                            
                 </form>
                  
                  <?php
              }
              
              ?>

              </li>

        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->
        
        
        
        
        
        
        
        <main id="main">
          <section class="inner-page">
              
              <?php
              
              if ($userType >2){
              
              
              ?>
              
              
              

            <section class="signup">
                <div class="container">
                    <div class="signup-content">
                        <form method="POST" id="signup-form" name="myform" class="signup-form">
                            <h2 class="form-title">Add <span>Restaurant</span></h2>
                            &nbsp;
                            
                            <div class="form-group">
                                <input type="text" class="form-input input-lg" name="name" id="name" placeholder="name" required/>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-input input-lg"  name="email" id="email"  placeholder="email" required/>
                            </div>
                            
                              <div class="form-group">
                                 <input type="tel" id="phone" name="phone" class="form-input input-lg" placeholder="123456789" pattern="[29]{1}[0-9]{8}" required>
                            </div>
                            
                            <div class="form-group">
                                <textarea rows = "5" cols = "39" name = "description" class="area" placeholder="description" maxlength="116" required></textarea>
                            </div>
                            
                                     &nbsp;
                                     
                                      
                                     <div class="form-group"><strong><p class="select_p">
                                                 Select restaurant picture cover:</p></strong>
                                         
                                         <input  type="file"  name="uploadfile" class="inputFile" accept="image/*" required/>
                                    </div>
                                    
                                
                                      
                             &nbsp;
                            <div><input type="hidden" name="test" id= "test" value="1"></div>
                            
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                            <div class="container1">
                                <button class="add_form_field">Add new item to menu
                                    
                                    <span style="font-size:16px; font-weight:bold;">+ </span>
                                </button>
                                <p>
                                <div><input type="text" name="myname1" class="selectStuff" placeholder="food 1" required><small>aa</small><input type="number" class="selectStuff" name="myprice1" placeholder="price 1" required><small>aa</small><input  class="selectStuff" type="text" name="mydes1" placeholder="descrip 1" required></div>
                            </div>
                            
        
        
        <?php
 
     require_once( "../Lib/lib.php" );
     require_once( "../Lib/db.php" );
    
    

    
    # obter last id restaurante
    $sqlId = "SELECT * FROM `restaurant` ORDER BY `id` DESC LIMIT 1";
    $rowId = mysqli_query( $GLOBALS['ligacao'], $sqlId );
    
    
    $MAX_ID=0;
     while ($row = $rowId->fetch_assoc()) {
        //echo $row['id'];
        if(isset($row['id'])){
             $MAX_ID=$row['id'];
        }
     }
     $_SESSION['restaurantId'] = $MAX_ID+1;
    
   
    
    
    # obter tipos de comidas
    $sql = "SELECT name_type FROM `type`";
    
    $result=mysqli_query( $GLOBALS['ligacao'], $sql );
    
    $storeArray = Array();
    
    $row = $result->fetch_array(MYSQLI_NUM);
    //echo $row[0];
    
    array_push($storeArray, $row[0]);
    
    while($row = $result->fetch_array())
    {
    $rows[] = $row;
    }

    foreach($rows as $row)
    {
    //echo $row['name_type'];
    array_push($storeArray, $row['name_type']);
    }
    
 
    ?>
           <div class="form-group">  
               <br>
               <h4>
               Choose food types:
               </h4>
            
    <?php
    $i=1;
    foreach ($storeArray as $a){
        //echo $x;
        echo('<input type="checkbox" id="type'.$i.'" name="type'.$i.'" value="'.$a.'">');
        echo('<label for="type'.$i.'">'.$a.'</label><br>');
    ?>
                           
    <?php
        $i++;
    }
         ?>
               
                            </div>
                             <div class="form-group">
                                 <label for="open">Choose opening time:</label>
                                 <input type="time" id="open" name="open" required>
                            </div>
                             <div class="form-group">
                                 <label for="close">Choose closing time:</label>
                                 <input type="time" id="close" name="close" required>
                            </div>
                            <br>

                            <div id="map"></div>
                           
                            <br>
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
                        alert("Location: " + results[1].formatted_address);
                        var res = results[1].formatted_address.split(",");
                        
                        
                        var a= res[1].substring(1);
                        a= a.split(" ");
                        //console.log(a[0]);
                        //console.log(a[1]);
                        var post= a[0];
                        var address = res[0];
                        var city = "";
                        var i=0;
                        a.forEach(function(item, index, array) {
                            if (i!==0){
                                city=city + " " +item;
                            }
                            //console.log(item);
                            i++;
                        })
                        console.log(address);
                        city= city.substring(1);
                        console.log(city);
                        console.log(post);
                        
                        document.getElementById("add").value =address;
                        document.getElementById("city").value =city;
                        document.getElementById("post").value =post;
                        
                    }
                     
                }
            });
        }
        
    </script>
                        
    
                        <div><input type="hidden" name="lat" id= "lat" value=""></div>
     
                        <div><input type="hidden" name="log" id= "log" value=""></div>
      
                        <div><input type="hidden" name="add" id= "add" value=""></div>
                        
                        <div><input type="hidden" name="post" id= "post" value=""></div>
      
                        <div><input type="hidden" name="city" id= "city" value=""></div>
                            <div class="form-group">
                                <input type="submit" name="submit" id="submit"  class="btn btn-primary" value="Add"/>
                            </div>
                     
                        </form>
                       
                    </div>
                </div>
            </section>
              
              
              <?php
              
              }
              
              else{
                  
                 ?>
              
              
              <h1> You don't have permission to access this content </h1>
              
              <?php
                  
                  
              }
              
              
              
              ?>
              
              
              
              
              
              
              
                   </section>
        </main>
  
    <footer id="footer">
    <div class="container">
      <h3>ChuckYummy</h3>
      <p>If you're looking foor good food, ChuckYummy is the place to go</p>
   
      <div class="copyright">
        &copy; Copyright <strong><span>Delicious</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/delicious-free-restaurant-bootstrap-theme/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End Footer -->

    <?php
    

    
   
    
    
    if(isset($_POST["submit"])){
        
        
            
            
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $imagePath= $_POST['uploadfile'];
        $open = $_POST['open'];
        $close = $_POST['close'];
        $resDes = $_POST['description'];
        
        
        //criar folder
        $path="C:/Users/pedro/OneDrive/Ambiente de Trabalho/SMI/Exemplos/PHP/Projecto/uploads";
        $fullPath=$path . "/" . $userName;
        
        if (!file_exists($fullPath)) {
        mkdir($fullPath, 0777, true);
        }
        copy($path."/".$imagePath, $fullPath."/".$imagePath);
        $pathDB=$userName."/".$imagePath;
        
        
         # inserir restaurante
         $insertQuery = "INSERT INTO `restaurant`(`id` ,`name`, `email`, `telephone`, `photo`, `location_id`, `public`,`opening_time`,`closing_time`,`description`)
                 VALUES ($MAX_ID+1,'".$name."','".$email."','".$phone."','".$pathDB."',1,1,'".$open."','".$close."','".$resDes."')";

         $insertRes=mysqli_query( $GLOBALS['ligacao'], $insertQuery );
         
         //$numberFoods= $_POST['foods'];
         
         $numberTypes= $_POST['test'];
             for ($x = 1; $x <= $numberTypes; $x++) {
             
             $food_name=$_POST['myname'.$x];
             $food_price=$_POST['myprice'.$x];
             $food_des=$_POST['mydes'.$x];
    
             # inserir menu
             $insertQuery = "INSERT INTO `menu`( `restaurant_id`, `name`, `price`,`descrip`)
                 VALUES ($MAX_ID+1,'".$food_name."','".$food_price."','".$food_des."')";

             $insert=mysqli_query( $GLOBALS['ligacao'], $insertQuery );
            
            } 
            
            //echo('TESTE: '.$i);
            
            for ($x = 1; $x <= $i; $x++) {
                
                if(isset($_POST['type'.$x])){
                    
                $types=$_POST['type'.$x];
                 //echo('Carregou'.$types.'<br>' );
                 
                 $sql = "SELECT `id` FROM `type` WHERE `name_type`='$types'";
    
                 $result=mysqli_query( $GLOBALS['ligacao'], $sql );
                 
                 
                 while ($row = $result->fetch_assoc()) {
                    //echo $row['id']."<br>";
                    
                    # inserir tipos de comida no restairante
                     $insertQuery = "INSERT INTO `restaurant_type`( `type_id`, `restaurant_id`)
                     VALUES ('".$row['id']."',$MAX_ID+1)";

                    $insert=mysqli_query( $GLOBALS['ligacao'], $insertQuery );
                    
                    }
                }
            }

         /*
         for ($x = 0; $x < $numberFoods; $x++) {
             
             $food_name=$_POST['foodname'.$x];
             $food_price=$_POST['foodprice'.$x];
             
             $insertQuery = "INSERT INTO `menu`( `restaurant_id`, `name`, `price`)
                 VALUES (2,'".$food_name."','".$food_price."')";

             $insert=mysqli_query( $GLOBALS['ligacao'], $insertQuery );
            
            } 
            
            $numberTypes= $_POST['test'];
             for ($x = 1; $x <= $numberTypes; $x++) {
             
             $type_name=$_POST['mytext'.$x];
    
             
             $insertQuery = "INSERT INTO `restaurant_type`( `type`, `restaurant_id`)
                 VALUES ('".$type_name."',2)";

             $insert=mysqli_query( $GLOBALS['ligacao'], $insertQuery );
            
            } */
            
            ?>
         <script>
            
          window.location.href = "addPictures.php";
            
         </script>
            <?php
            
           
          
            
            
            $lat = $_POST['lat'];
            $log = $_POST['log'];
            $add = $_POST['add'];
            $city = $_POST['city'];
            $post = $_POST['post'];
            
            # inserir location
            $insertQuery = "INSERT INTO `restaurant_location`(`idRestaurant`, `address`, `latitude`, `longitude`,`City`,`post_code`)
                 VALUES ($MAX_ID+1,'".$add."','".$lat."','".$log."','".$city."','".$post."')";

            $insert=mysqli_query( $GLOBALS['ligacao'], $insertQuery );
            
            
           
            
         
            
         }
         
    ?>
  
    </body>
    
</html>
