<!DOCTYPE html>
<?php
session_start();


include 'getuserInfo.php';

$homeLink = "TemplateLogIn.php";

$login = 0;
$userType = 0;
$userId = 0;

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
            $userId = $_SESSION['userId'];
            $userType = getUserAuthRole($userId);
                
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
    
    $id = $_SESSION["userId"];


    
    $insertQuery = "SELECT * FROM `user_table` WHERE `userId` =$id";
    $insert=mysqli_query( $GLOBALS['ligacao'], $insertQuery );
    
    $userName = "";
    $gender = "";
    $birthdate = "";
    $email = "";
    $numComments = 0;
    $numClass = 0;
    $typeName = "";
    $nat = "";
    
    
    while($row = $insert->fetch_assoc()) {
                  
            $userName = $row["name"];
            $genderVal = $row["gender"];
            $birthdate = $row["birthdate"];
            $email = $row["email"];
            $nat = $row["nationality"];
            
            if ($genderVal){
                $gender = "male";
            }
            else{
                $gender = "female";
            }
    }
    
    $insertQueryCommentsNumb ="SELECT COUNT(user_id)  as `count` FROM `comment` WHERE user_id = $id ";
    $insertQueryClassNumb ="SELECT COUNT(user_id) as `count` FROM `classification` WHERE user_id = $id ";
    $insertQueryTypeName="SELECT `name_role` FROM `auth_role` WHERE `id` = $id  ";
    
    
    $insertNumComments=mysqli_query( $GLOBALS['ligacao'], $insertQueryCommentsNumb );
    $insertNumClass=  mysqli_query( $GLOBALS['ligacao'], $insertQueryClassNumb );
    $insertType = mysqli_query( $GLOBALS['ligacao'], $insertQueryTypeName );
     while($row = $insertNumComments->fetch_assoc()) {
         
         $numComments = $row["count"];
     }
     
      while($row = $insertNumClass->fetch_assoc()) {
         
          $numClass = $row["count"];
     }
     
      while($row = $insertType->fetch_assoc()) {
         
          $typeName = $row["name_role"];
     }
 
     

?>



<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>User</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="assets/img/icon.png" rel="icon">
  
  
    <!-- Template Main CSS File -->
 


    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,600,600i,700,700i|Satisfy|Comic+Neue:300,300i,400,400i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/user.css?v=<?php echo time(); ?>">




  
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
                <li  class="active"><a href="user.php">Profile</a></li>
                <li><a href="AddRestaurant.php">Add restaurant</a></li>
              <?php
              
          }
          
           else if ($userType == 4){
              
              ?>
                <li  class="active"><a href="user.php">Profile</a></li>
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

  <main id="main">

       <section class="inner-page">
           
           
<!------ Include the above in your HEAD tag ---------->

<div class="container">
	<div class="row">
        
       <div class="col-md-10 ">

<div class="panel panel-default">
  <div class="panel-heading">  <h1 ><?= $userName   ?></h1></div>
   <div class="panel-body">
       
    <div class="box box-info">
        
            <div class="box-body">
                     <div class="col-sm-3">
                         <div  align="center"> <img alt="User Pic" src="assets/img/chefs/chefs-1.jpg" id="profile-image1" class="img-circle img-responsive"> 
                
                <input id="profile-image-upload" class="hidden" type="file">
<div style="color:#999;" >click here to change profile image</div>
                <!--Upload Image Js And Css-->
           
 
                     </div>
              
              <br>
    
              <!-- /input-group -->
            </div>
           
            <div class="clearfix"></div>
            <hr style="margin:5px 0 5px 0;">
    
              
     



<div class="col-sm-5 col-xs-6 tital " ><h3> Gender:<h3> </div><div class="col-sm-7 col-xs-6 "><h4><?= $gender?></h4></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " ><h3> Birthdate:<h3> </div><div class="col-sm-7 col-xs-6 "><h4><?= $birthdate ?></h4></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " ><h3> Email:<h3> </div><div class="col-sm-7 col-xs-6 "><h4><?= $email   ?></h4></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " ><h3> Nationality:<h3> </div><div class="col-sm-7 col-xs-6 "><h4><?= $nat   ?></h4></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<div class="col-sm-5 col-xs-6 tital " ><h3> Number of ratings:<h3> </div><div class="col-sm-7 col-xs-6 "><h4><?= $numComments ?></h4></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>


<div class="col-sm-5 col-xs-6 tital " ><h3> User Type:<h3> </div><div class="col-sm-7 col-xs-6 "><h4><?= $typeName  ?></h4></div>
     <div class="clearfix"></div>
<div class="bot-border"></div>

<!-- EDIT BUTTON !-->
<div class="col-sm-3 col-xs-6 tital " >
    <form method="POST" id="edit_user_form" name="editForm" class="signup-form" action="editUser.php">
<div class="form-group_2">
       <input type="submit" id="submit" type="button" class="btn btn-primary"  value="Edit"/>
        </div>
                            
     </form>
</div>


            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
       
            
    </div> 
    </div>
</div>  
    <script>
              $(function() {
    $('#profile-image1').on('click', function() {
        $('#profile-image-upload').click();
    });
});       
              </script> 
       
  
   </div>
    
 
    </p>
   
        
    <div id="favorite_restaurants_2">
       <h1> Favorite <span>Restaurants</span> </h1>
  
 &nbsp;
 <p>

     
   <div class="row no-gutters">  
       

    <?php  
     $querySql = "select `id` from `restaurant` inner JOIN `user_favorite_restaurant` on `restaurant_id` = `id` where `user_id` = $userId ";
            
     $insert = mysqli_query( $GLOBALS['ligacao'], $querySql );
     
     $arrayResId= array();
     $resId = null;
     $photo = null;
     $resName = null;
     while ($row = $insert->fetch_assoc()) {
         

         
       if( isset ($row['id'])){
       $resId=$row['id'];
       array_push($arrayResId,$resId);
       }
       
       
     }
      
     if ($resId!=null){
         
         ?>
       
       
       
       <?php
       
         foreach ($arrayResId as $value) {
           
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
              
              
              
               ?>
      
            <div class="card">
            

            <h3 class="card-title"><?=$nameRes?></h3>
            <a  href="restaurant.php?id=<?php echo "$value" ?>" class="stretched-link"></a>
            <img class="card-img-top4" alt="Card image cap" src=<?php echo "uploads/".$photoRes; ?> />
            
            <div class="card-block">

             <p class="card-text">
          
           
   <?php


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
        </div>
       &nbsp;
  <?php
              
      
             
             
             
             
         }
         
        

   
 }
      ?> 
    </div>
    

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