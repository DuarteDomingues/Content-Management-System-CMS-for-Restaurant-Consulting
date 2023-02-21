<?php

session_start();

include 'getuserInfo.php';

$homeLink = "TemplateLogIn.php";


$login = 0;
$userName = "";

 if (session_status() == PHP_SESSION_ACTIVE){
        if( isset($_SESSION['name']) && !empty($_SESSION['name'])){
            $login = 1; 
            $homeLink = "user.php";
            $userName = $_SESSION['name'];
            
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

    <?php
 
require_once( "../Lib/lib.php" );
   require_once( "../Lib/db.php" );
    
    
    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    
    $restaurants=$_SESSION['searchRestaurants'];
    
    foreach ($restaurants as $value) {
    echo($value);
    echo("<br>");
    }
    $restaurants=[5,6,7,8,9,10]
    ?>

<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>See Restaurants</title>
       
      <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="assets/img/icon.png" rel="icon">
           
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,600,600i,700,700i|Satisfy|Comic+Neue:300,300i,400,400i,700,700i" rel="stylesheet">
        
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
        <script src="scripts/main.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <link href="Img/favicon.png" rel="icon">
        <link href="Img/apple-touch-icon.png" rel="apple-touch-icon">
        
       
    
      <link rel="stylesheet" href="assets/css/user.css">
      
      <style>
          
          .red-color {
            color:red;
            font-size: 34px;
            
          }
          .fa { 
              
              
          }
          .bts{
              border: none;
          }
          .green-color{
               color:green;
               font-size: 32px;
          }

    </style>

        
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
          <li ><a href="user.php">Profile</a></li>
                         <li class="active"><a href="AddRestaurant.php">Add Restaurant</a></li>

    
          
        
  
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

            <section class="signup">
                <div class="container">
                    <div class="signup-content">
                        <form method="POST" id="signup-form" name="myform" class="signup-form">
                           
                            &nbsp;
                            
                            <div class="container">

   
             <h1> See <span>Restaurants<span>  </h1>
         &nbsp;
<section id="gallery" class="gallery">
    <div class="card-deck">
        
        <?php
        
                      foreach ($restaurants as $key => $value) {
                          
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
                          $classRes;
                          $idRes=$value;
                          //echo($idRes);
                          //echo("<br>");
                          
                          if (mysqli_num_rows($resultRestaurants)!=0) { 

                          while ($row = $resultRestaurants->fetch_assoc()) {
                            
                            $publicRes=$row['public'];
                            $nameRes=$row['name'];
                            $photoRes=$row['photo'];
                            $cityRes=$row['City'];
                            $classRes=$row['class'];
        
                           }
                           $classRes= avgRatingRestaurant($value);
                           
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
                                $classRes="0";
        
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
            <div class="card">
                <a href="restaurant2.php?id=<?php echo $idRes; ?>">
            <p>
            <h4 class="card-title" ><?=$nameRes ?></h4>
            
            <img class="card-img-top" src="<?php echo "uploads/".$photoRes; ?>" alt="Card image cap" height="200">
            <div class="card-block">
 
                <p class="card-text">
                                  
           <p class="card-text">
             <small class="text-muted"><?=$cityRes?></small>
                  </p>
             <p class="card-text">
             <small class="text-muted"><?=$tipos?></small>
                  </p>
                  
                     <ul class="list-group list-group-flush">
                         
             <li class="list-group-item"> Rating: <?php echo $classRes; ?></li>
          
             </ul>
                    
            </div>
            
        </div>
        
                           
                <?php
                }

        ?>

    </div>
    </section>   
 </div>                           
                       

                     
                        </form>
                       
                    </div>
                </div>
            </section>
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
                                    
                                     
                                      
                                   
           
                            
        
        

  
 
