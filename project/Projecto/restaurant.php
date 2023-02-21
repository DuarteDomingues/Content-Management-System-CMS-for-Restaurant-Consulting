<!DOCTYPE html>
<?php
session_start();


include 'getuserInfo.php';

$homeLink = "TemplateLogIn.php";

$login = 0;
$userType = 0;
$user_id = 0;

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
            $user_id = $_SESSION['userId'];
            $userType = getUserAuthRole($user_id);
                
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
  


    
    if(isset($_GET['id'])){
        
        $resId= $_GET['id'];
    }else {
    echo "failed";
    }
    
    
    
    //obter restaurant info
    $sql = "SELECT * FROM `restaurant` WHERE `id` = '".$resId."'";
    $result  = mysqli_query( $GLOBALS['ligacao'], $sql );
    
    $resName;
    $resEmail;
    $resTelephone;
    $resPhoto;
    $resLocalId;
    $resPublic;
    $resOpenTime;
    $resCloseTime;
    $resDescription;
    
    $restRating = avgRatingRestaurant($resId);
   
    
    while ($row = $result->fetch_assoc()) {
        $resName = $row['name'];
        $resEmail = $row['email'];
        $resTelephone = $row['telephone'];
        $resPhoto = "uploads"."/".$row['photo'];
        $resLocalId = $row['location_id'];
        $resPublic = $row['public'];
        $resOpenTime = $row['opening_time'];
        $resCloseTime = $row['closing_time'];
        $resDescription= $row['description'];
     }
     
     //obter restautant menu
     $sql = "SELECT *  FROM `menu` WHERE `restaurant_id` = '".$resId."' ORDER BY `id` ASC";
     $result  = mysqli_query( $GLOBALS['ligacao'], $sql );
     
     $menu;
     $menus=array();
     
      while ($row = $result->fetch_assoc()) {
       
        $menu = [
        "name" => $row['name'],
        "des" => $row['descrip'],
        "price" => $row['price'],
        ];
        array_push($menus, $menu);
     }
   
     //obter restaurant local
     $sql = "SELECT *  FROM `restaurant_location` WHERE `idRestaurant` = '".$resId."'";
     $result  = mysqli_query( $GLOBALS['ligacao'], $sql );
     
     $address;
     $latitude;
     $longitude;
     $city;
     $post;
     
     
      while ($row = $result->fetch_assoc()) {
        $address = $row['address'];
        $latitude = $row['latitude'];
        $longitude = $row['longitude'];
        $city = $row['City'];
        $post = $row['post_code'];
     }
     
     
     //obter restaurant tipos
     $sql = "SELECT *  FROM `restaurant_type` WHERE `restaurant_id` = '".$resId."'";
     $result  = mysqli_query( $GLOBALS['ligacao'], $sql );
     
     $tiposId=array();
     
     while ($row = $result->fetch_assoc()) {
         
         array_push($tiposId, $row['type_id']);
     }
     
     $tiposName="";
     $typesNames=array();
     
     for ($index = 0; $index < count($tiposId); $index++) {
         
     $sql = "SELECT `name_type` FROM `type` WHERE `id` = '".$tiposId[$index]."'";
     $result  = mysqli_query( $GLOBALS['ligacao'], $sql );
     while ($row = $result->fetch_assoc()) {
         //echo( $row['name_type']);
         $tiposName=$tiposName.", ".$row['name_type'];
         array_push($typesNames, $row['name_type']);
     }
     
    }
    $tiposName=ltrim($tiposName, $tiposName[0]);
     
     
     
     
     
     
     if( isset($_POST["submitFavorite"])){
         
         insertFavoriteRestaurant($resId, $user_id);
         
         
         
     }

     
     //----------------------------------------HANDLE COMMENT----------------------------------------------
     
         if( isset($_POST["submitCommentForm"])){
        
        $textAreaText = $_POST['commentText'];
        $starVal = $_POST['starValue'];
        $starNumb = 0;
        if ($starVal == 0){
            $starNumb = 5;
        }
        else if ($starVal == 1){
            $starNumb = 4;
        }
        else if ($starVal == 2){
            $starNumb = 3;
        }
         else if ($starVal == 3){
            $starNumb = 2;
        }
        else if ($starVal == 4){
            $starNumb = 1;
        }
            
                   
        $currDate  = date("Y-m-d");
        
     
        
        //----------------add coment to database----------------------------------------
        
        $insertQuery = "INSERT INTO `comment`( `restaurant_id`, `user_id`, `text`,`class`,`date_comment`)
        VALUES ($resId,$user_id,'".$textAreaText."',  $starNumb     , '".$currDate."')";
        
        $insert=mysqli_query( $GLOBALS['ligacao'], $insertQuery );
        
        header("Refresh:0");

         }
     
     
     
     //SELECT * from `comment` where `restaurant_id` = 8 
         
         
         
     
     
     
     
     
     
     
  ?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?=$resName ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="assets/img/icon.png" rel="icon">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">


  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,600,600i,700,700i|Satisfy|Comic+Neue:300,300i,400,400i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    
    <script type="text/javascript" src="assets/js/stars.js"> </script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>


  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="assets/css/restaurant.css?v=<?php echo time(); ?>">

  

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
     let map;

function initMap() {
  const myLatLng = { lat: <?=$latitude ?>, lng: <?=$longitude ?> };
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 12,
    center: myLatLng,
  });
  var marker = new google.maps.Marker({
    position: myLatLng,
    map,
   
  });
  

  
}

    </script>
  

    
    
    
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
                <li ><a href="user.php">Profile</a></li>
              <?php
          }
          
          else if ($userType == 3){
              
              ?>
                <li  ><a href="user.php">Profile</a></li>
                <li><a href="AddRestaurant.php">Add restaurant</a></li>
              <?php
              
          }
          
           else if ($userType == 4){
              
              ?>
                <li ><a href="user.php">Profile</a></li>
                <li><a href="AddRestaurant.php">Add restaurant</a></li>
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
 &nbsp;

 <div class="fill_space">
      &nbsp;

<p style="margin-left:2.5em"></p>     
<span style="padding-left:80px"> 
 </div>
  <main id="main">

       <section class="inner-page">

      <div class="container">

       <div id="restaurante_intro"> 
       <div id="justify_stuff">
           
      <?php
      if($resPublic==1 || $userType!=0){
         
      
      ?>

       <div class="card" style="width: 66rem; height: 64rem;" >
           <p>
                 <h1 class="card-title"><?=$resName ?></h1>
                 
                 
     
           <img
          src="<?=$resPhoto; ?>"
          class="img-fluid_2"    alt="..."
            />    
      
  <div class="card-body" >
    <p class="card-text" style="text-align:center;">
      <?=$resDescription?>
    </p>
    <p class="card-text">
      <small class="text-muted"><?=$address ?>,<?=" ".$post ?> <?=$city ?></small>
    </p>
    
   
    
     <ul class="list-group list-group-flush">
          <li class="list-group-item">Our food type:
              <span><?=$tiposName ?></span>
    </li>
         <li class="list-group-item">Open from <span><?=$resOpenTime ?> to <?=$resCloseTime ?> every day </span></li>
    <li class="list-group-item"> 

        
            <?php
                          
            if ($restRating >0.25 & $restRating<0.75){
                                    
             ?>
             <span ><i class="text-warning fa fa-star-half-o"></i></span>   
              <?php
                                    
              } 
              else if ($restRating >=0.75 & $restRating<1.25){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
              <?php
                                    
              } 
             else if ($restRating >=1.25 & $restRating<1.75){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
             <span ><i class="text-warning fa fa-star-half-o"></i></span>
              <?php
                                    
              } 
              
                else if ($restRating >=1.75 & $restRating<2.25){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
             <span ><i class="text-warning fa fa-star"></i></span>
              <?php
                                    
              } 
              
            else if ($restRating >=2.25 & $restRating<2.75){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
             <span ><i class="text-warning fa fa-star"></i></span>
             <span ><i class="text-warning fa fa-star-half-o"></i></span>

              <?php
                                    
              } 
             else if ($restRating >=2.75 & $restRating<3.25){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
             <span ><i class="text-warning fa fa-star"></i></span>
             <span ><i class="text-warning fa fa-star"></i></span>

              <?php
                                    
              } 
                  else if ($restRating >=3.25 & $restRating<3.75){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
             <span ><i class="text-warning fa fa-star"></i></span>
             <span ><i class="text-warning fa fa-star"></i></span>
              <span ><i class="text-warning fa fa-star-half-o"></i></span>

              <?php
                                    
              } 
                    else if ($restRating >=3.75 & $restRating<4.25){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
             <span ><i class="text-warning fa fa-star"></i></span>
             <span ><i class="text-warning fa fa-star"></i></span>
              <span ><i class="text-warning fa fa-star"></i></span>

              <?php
                                    
              } 
                
            else if ($restRating >=4.25 & $restRating<4.75){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
             <span ><i class="text-warning fa fa-star"></i></span>
             <span ><i class="text-warning fa fa-star"></i></span>
              <span ><i class="text-warning fa fa-star"></i></span>
              <span ><i class="text-warning fa fa-star-half-o"></i></span>

              <?php
                                    
              } 
              
                  else if ( $restRating>=4.75){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
             <span ><i class="text-warning fa fa-star"></i></span>
             <span ><i class="text-warning fa fa-star"></i></span>
              <span ><i class="text-warning fa fa-star"></i></span>
             <span ><i class="text-warning fa fa-star"></i></span>


              <?php
                                    
              } else if ($restRating <0.25){

             ?>
              <span><i class=" fa fa-star-o"></i></span>
                <span><i class=" fa fa-star-o"></i></span>
                  <span><i class=" fa fa-star-o"></i></span>
                    <span ><i class=" fa fa-star-o"></i></span>
                      <span><i class=" fa fa-star-o"></i></span>
              <?php

              }

             ?>
 
    </li>
  

  </ul>
    <p></p>
    
   <?php

        if (checkIfRestaurantFavorite($resId, $user_id) == 0){
            
            ?>
            
               <form method="post" name="formFavorite">
                    
                   
            <?php
            
            if ($login!= 0){
            ?>
            
            <button type="submit" name="submitFavorite" class="float-right btn text-white btn-danger"> <i class="fa fa-heart"></i> Add to favourites</a>
                    
                    
            <?php
            
            }
            ?>
                    
                    
            </form>
            <?php
                    
                    
                    
        }
        else{
            ?>
             <a href="user.php"class="float-right btn text-white btn-danger"/> <i class="fa fa-heart"></i> Added to favourites</a>
                
             <?php
        }   
         
   
   ?>
    
    
 
    </p>
  </div>
</div>
                      </div>

          
    </div>
       </div>  
          
     
      <section id="gallery" class="gallery">
          <!--<!-- container fluid pa ter imagens a oucpar full screen se quiser -->
      <div class="container">
          
        <div class="section-title">
          <h2>Pictures </h2>
          <p>Check out some pictures from our restaurant.</p>
        </div>
          <p>

        <div class="row no-gutters">
            
            <?php
                 $sql = "SELECT `path_image` FROM `restaurant_pictures` WHERE `restaurant_id` = '".$resId."'";
                 $result  = mysqli_query( $GLOBALS['ligacao'], $sql );
                 while ($row = $result->fetch_assoc()) {
                     $image = $row['path_image'];
                     ?>
            
             <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="<?php echo "uploads/".$image; ?>" class="venobox" data-gall="gallery-item">
                <img src="<?php echo "uploads/".$image; ?>" alt=""  width="300" height="200">
              </a>
            </div>
          </div>
                     
                     <?php
                 }
                 
            ?>

      
          </div>

          

        </div>

      </div>
    </section>
          

   <!-- ======= Menu Section ======= -->
    <section id="menu" class="menu">
      <div class="container">

        <div class="section-title">
            <h2>Menu</h2>
        </div>



        <div class="row menu-container">
            
            <?php
            
             for ($i = 0; $i < count($menus); $i++) {
         
                
                ?>
            
                <div class="col-lg-6 menu-item filter-starters">
                    <div class="menu-content">
                        <a href="#"><?=$menus[$i]['name'] ?></a><span>$<?=$menus[$i]['price'] ?></span>
                    </div>
                    <div class="menu-ingredients">
                        <?=$menus[$i]['des'] ?>
                    </div>
                </div>
                <?php
            }
            
            ?>

        </div>

      </div>
    </section>
   
<section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
            <h2>Visit<span> Us</span></h2>
          <p>Check out our restaurant location.</p>
        
      </div>
    <p>
        
     <div id="map"></div>
     </div>

    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgAJ_p2Q0c8cwyZZ98HMEojf9g0uakFDk&callback=initMap&libraries=&v=weekly"
      async
    ></script>

      <div class="container mt-5">

        <div class="info-wrap">
          <div class="row">
            <div class="col-lg-3 col-md-6 info">
                
              <i class="icofont-google-map"></i>
              <h4>Location:</h4>
              <p><?=$address ?>, <br><?=$post. " " ?><?=$city ?></p>
            </div>

            <div class="col-lg-3 col-md-6 info mt-4 mt-lg-0">
              <i class="icofont-clock-time icofont-rotate-90"></i>
              <h4>Open Hours:</h4>
              <p>Monday-Saturday:<br><?=$resOpenTime ?> - <?=$resCloseTime ?></p>
            </div>

            <div class="col-lg-3 col-md-6 info mt-4 mt-lg-0">
              <i class="icofont-envelope"></i>
              <h4>Email:</h4>
              <p><?=$resEmail?></p>
            </div>

            <div class="col-lg-3 col-md-6 info mt-4 mt-lg-0">
              <i class="icofont-phone"></i>
              <h4>Call:</h4>
              <p><?=$resTelephone ?></p>
            </div>
          </div>
        </div>
      </div>
</section>
   
   
      <div class="container">
   
             <h1> Similar <span>Restaurants<span>  </h1>
         &nbsp;
     
         <div class="row no-gutters"style="justify-content: center;" >
             
             <?php
             
             
             $type=$typesNames;
             
             
             $arrayTypes=array();
             
             foreach ($type as $value) {
                 
                 $sql = "SELECT * FROM `restaurant_type` inner join `type`\n"

                . "on `restaurant_type`.`type_id`=`type`.`id`\n"

                . "where `name_type`LIKE '$value%'";
             
             
             $resultRestaurantsTiposLike = mysqli_query( $GLOBALS['ligacao'], $sql );
             

              while ($row = $resultRestaurantsTiposLike->fetch_assoc()) {
                  
                  //$publicRes=$row['restaurant_id'];
                  //echo($row['restaurant_id']." ");
                  array_push($arrayTypes, $row['restaurant_id']);
              }
                 
             }
             
             $arrayTypes = array_unique($arrayTypes);
             $arrayTypes = array_diff($arrayTypes, [$resId]);
             
             foreach ($arrayTypes as $value) {
                 
                   $sql = "SELECT *\n"

                            . "FROM `restaurant`\n"

                            . "INNER JOIN `restaurant_location`\n"

                            . "    on `restaurant`.`id` = `restaurant_location`.`idRestaurant`\n"

                            . "INNER JOIN `comment`\n"

                            . "    on `restaurant`.`id` = `comment`.`restaurant_id`\n"

                            . "WHERE `id` = '".$value."'";
                          
                          
                          $resultRestaurants = mysqli_query( $GLOBALS['ligacao'], $sql );
                          
                          $publicRes;
                          $nameRes;
                          $photoRes;
                          $cityRes;
                          $restRating;
                          $idRes=$value;
                          //echo($idRes);
                          //echo("<br>");
                         
                          
                           if (mysqli_num_rows($resultRestaurants)!=0) { 
     
                          while ($row = $resultRestaurants->fetch_assoc()) {
                            
                            $publicRes=$row['public'];
                            $nameRes=$row['name'];
                            $photoRes=$row['photo'];
                            $cityRes=$row['City'];
                            $restRating=$row['class'];

                           }
                           $restRating= avgRatingRestaurant($value);
                           }else{
                             
                              $sql = "SELECT * FROM `restaurant` inner join `restaurant_location`\n"

                                . "on `restaurant`.`id`=`restaurant_location`.`idRestaurant`\n"

                                . "where `id`='".$value."'";
                              
                              $resultRestaurants = mysqli_query( $GLOBALS['ligacao'], $sql );
                               while ($row = $resultRestaurants->fetch_assoc()) {
                            
                                $publicRes=$row['public'];
                                $nameRes=$row['name'];
                                $photoRes=$row['photo'];
                                $cityRes=$row['City'];
                                $restRating="0";
        
                                }
                              
                              
                          }
                           
                          
                           $sqlTipos = "SELECT * FROM `restaurant_type`\n"

                           . "INNER JOIN `type` \n"

                           . "on `restaurant_type`.`type_id` = `type`.`id`  \n"

                            . "WHERE `restaurant_id`='".$value."'";
                           
                            $tipos="";
                            $i=0;
                            $resultRestaurantsTipos = mysqli_query( $GLOBALS['ligacao'], $sqlTipos );
                             while ($row = $resultRestaurantsTipos->fetch_assoc()) {
                                 
                                 $tipo=$row['name_type'];
                                 
                                 if($i!=0){
                                      $tipos=$tipos.", ".$tipo;
                                 }else{
                                     $tipos=$tipos.$tipo;
                                 }

                                 $i++;
                             }
                           
                      
                           ?>
            <div class="card_hover">
            
                    <div class="card">
                        
                        <a href="restaurant.php?id=<?php echo $idRes; ?>">


     <h4 class="card-title"><?= $nameRes ?>  </h4> 
     <img class="card-img-top" src="<?php echo "uploads/".$photoRes; ?>" alt="Card image cap" height="200">

  <div class="card-block">
      
      


 <p class="card-text">
              
    <p class="card-text">
      <light class="text-muted"><?=$cityRes?></light>
       </p>
       
          <h3 class="card-text"  style="font-size:14px">
     <?=$tipos?>
       </h3>
       
       
    
      <ul class="list-group list-group-flush">
          
          
          
          <li class="list-group-item">
              
               <?php
                          
            if ($restRating >0.25 & $restRating<0.75){
                                    
             ?>
             <span ><i class="text-warning fa fa-star-half-o"></i></span>   
              <?php
                                    
              } 
              else if ($restRating >=0.75 & $restRating<1.25){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
              <?php
                                    
              } 
             else if ($restRating >=1.25 & $restRating<1.75){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
             <span ><i class="text-warning fa fa-star-half-o"></i></span>
              <?php
                                    
              } 
              
                else if ($restRating >=1.75 & $restRating<2.25){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
             <span ><i class="text-warning fa fa-star"></i></span>
              <?php
                                    
              } 
              
            else if ($restRating >=2.25 & $restRating<2.75){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
             <span ><i class="text-warning fa fa-star"></i></span>
             <span ><i class="text-warning fa fa-star-half-o"></i></span>

              <?php
                                    
              } 
             else if ($restRating >=2.75 & $restRating<3.25){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
             <span ><i class="text-warning fa fa-star"></i></span>
             <span ><i class="text-warning fa fa-star"></i></span>

              <?php
                                    
              } 
                  else if ($restRating >=3.25 & $restRating<3.75){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
             <span ><i class="text-warning fa fa-star"></i></span>
             <span ><i class="text-warning fa fa-star"></i></span>
              <span ><i class="text-warning fa fa-star-half-o"></i></span>

              <?php
                                    
              } 
                    else if ($restRating >=3.75 & $restRating<4.25){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
             <span ><i class="text-warning fa fa-star"></i></span>
             <span ><i class="text-warning fa fa-star"></i></span>
              <span ><i class="text-warning fa fa-star"></i></span>

              <?php
                                    
              } 
                
            else if ($restRating >=4.25 & $restRating<4.75){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
             <span ><i class="text-warning fa fa-star"></i></span>
             <span ><i class="text-warning fa fa-star"></i></span>
              <span ><i class="text-warning fa fa-star"></i></span>
              <span ><i class="text-warning fa fa-star-half-o"></i></span>

              <?php
                                    
              } 
              
                  else if ( $restRating>=4.75){
                                    
             ?>
             <span ><i class="text-warning fa fa-star"></i></span>   
             <span ><i class="text-warning fa fa-star"></i></span>
             <span ><i class="text-warning fa fa-star"></i></span>
              <span ><i class="text-warning fa fa-star"></i></span>
             <span ><i class="text-warning fa fa-star"></i></span>


              <?php
                                    
              } else if ($restRating <0.25){

             ?>
              <span><i class=" fa fa-star-o"></i></span>
                <span><i class=" fa fa-star-o"></i></span>
                  <span><i class=" fa fa-star-o"></i></span>
                    <span ><i class=" fa fa-star-o"></i></span>
                      <span><i class=" fa fa-star-o"></i></span>
              <?php

              }
               ?>
              
              
          </li>
   
   </ul>

             
       </div>
     </a>
     </div>
            </div>
             &nbsp;
             
                          
              <?php
             }
             
             ?>
      
        
   
    </div>
         </div>  
         
         
            &nbsp;
            <br>
            <br>
            <br>
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
         &nbsp;   
         
         
         <!--       <!-- COMENTARIO FIELD  -->
         
         
         <?php
         
         $userCommented = checkUserCommented($user_id,$resId);
         
         
         if ($login == 1 && $userCommented == 0){
             
           
         ?>
         
         <div class="container">
             
             <div class="container">
  <span id="rateMe2"  class="empty-stars"></span>
</div>
      
  
     
             
<div class="container">
    
    <h1>Reviews </h1>
  
  </div>	

    <form method="POST" id="comment_form" name="commentForm" class="comment-form" onsubmit="return getStarsValue(this )"  >
        <div class="bg-light p-2 ">
          <div class="starrating risingstar d-flex  flex-row-reverse" name="stars_ratings">
            <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="5 star"></label>
            <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 star"></label>
            <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 star"></label>
            <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 star"></label>
            <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star"></label>
            <div><input type="hidden" name="starValue" id= "add" value=""></div>

        </div>
                    
                    <div class="d-flex flex-row align-items-start"><img class="rounded-circle" src="https://i.imgur.com/RpzrMR2.jpg" width="40"><textarea class="form-control ml-1 textarea" name="commentText" placeholder="Comment..."></textarea></div>
                    
                    <div class="mt-2 text-right"><button class="btn btn-primary btn-sm shadow-none" name="submitCommentForm" type="submit">Post </button></div>
                </div>
             
            </div>
             
        
             
        </form>
             
       </div>

       
        <?php
       }
       
       else{
           
           if ($login == 0){
           ?>
           
           <h3 style="text-align:center;">Login to comment on restaurants </h3>

       
       
               <?php

           }
           
           else{
                ?>
           
           <h3 style="text-align:center;">You have alreay rated this restaurant </h3>

       
       
               <?php
               
           }
           
           
           
           
       }
       
       
          ?>
              &nbsp;
           <p>
                
         <div class="container">
            
             
         <?php
                    
            $sql = "SELECT * from `comment` where `restaurant_id` = '".$resId."' order by  `date_comment` desc";  
            $insert=mysqli_query( $GLOBALS['ligacao'], $sql );
            
            while($row = $insert->fetch_assoc()) {

                   
               $user_id = $row["user_id"];
               $name = getUserNameById($user_id);
               $text = $row["text"];
               $dateComment = $row["date_comment"];
               $class = $row["class"];
               
              ?>
             <div class="card">
	    <div class="card-body">
	        <div class="row">
        	    <div class="col-md-2">
        	        <img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid"/>
        	        <p class="text-secondary text-center"><?= $dateComment?></p>
        	    </div>
        	    <div class="col-md-10">
        	        <p>
        	            <a class="float-left"><strong><?=$name?></strong></a>
                            
                            
                            <?php
                            
                                if ($class ==1){
                                    
                                    ?>
                             <span class="float-right"><i class="text-warning fa fa-star"></i></span>   
                                      <?php
                                    
                                    
                                } 
                                else if ($class ==2){

                                       ?>
                             <span class="float-right"><i class="text-warning fa fa-star"></i></span>  
                              <span class="float-right"><i class="text-warning fa fa-star"></i></span>  
                                      <?php
                                    
                                    
                                }
                                   else if ($class ==3){

                                       ?>
                             <span class="float-right"><i class="text-warning fa fa-star"></i></span>  
                              <span class="float-right"><i class="text-warning fa fa-star"></i></span>  
                               <span class="float-right"><i class="text-warning fa fa-star"></i></span>  

                                      <?php
                                    
                                    
                                }
                                
                                    else if ($class ==4){

                                       ?>
                             <span class="float-right"><i class="text-warning fa fa-star"></i></span>  
                              <span class="float-right"><i class="text-warning fa fa-star"></i></span>  
                               <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                             <span class="float-right"><i class="text-warning fa fa-star"></i></span>  


                                      <?php
                                    
                                    
                                }
                                       else if ($class ==5){

                                       ?>
                             <span class="float-right"><i class="text-warning fa fa-star"></i></span>  
                              <span class="float-right"><i class="text-warning fa fa-star"></i></span>  
                               <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                             <span class="float-right"><i class="text-warning fa fa-star"></i></span>  
                              <span class="float-right"><i class="text-warning fa fa-star"></i></span>  



                                      <?php
                                    
                                    
                                }
                                
                            
                            ?>
                   
        	       </p>
        	       <div class="clearfix"></div>
        	        <p><?=$text?></p>
        	       
        	    </div>
	        </div>
	        	
            
	            </div>
	    </div>
             
             &nbsp;
             <p>
             <?php
 
            }
                    
                    
         ?>
             
  
       </div>
           <?php
          
      }
      
      else{
          
          ?>
          
          
          <div class="card" style="width: 66rem; height: 42rem;  align-items: center;" >
           <p>
                 <h1 class="card-title"><?=$resName ?></h1>
                 
                 
     
            <img
          src="assets/img/remove_button.png" 
          class="img-fluid_3"    alt="..."
         
            />
      
  <div class="card-body" >
    <p class="card-text" style="text-align:center;">
     
        <span style="font-size:30px">Content Unavailable</span>
    </p>
   

  </div>
</div>
          
          
 
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

</body>

</html>