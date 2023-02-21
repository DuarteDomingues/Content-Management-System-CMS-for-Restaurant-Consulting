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
  
    
    
        

    
    if(isset($_POST["submit_block_unblock"])){
                     $id = $_POST["userId"];
                     
    
        $querySql = "select `isBanned` from `user_table` where `userId` = $id ";
        $insert=mysqli_query( $GLOBALS['ligacao'], $querySql );     
        
        $isBlocked = null;
    
        while($row = $insert->fetch_assoc()) {
        
           $isBlocked = $row["isBanned"];
                  
   }
 
   
    $sqlUpdate = "";
       
        if ($isBlocked==0){
        
            $sqlUpdate = "UPDATE `user_table` SET `isBanned` = 1 WHERE `userId` = $id ";
        }

        
        else if ($isBlocked==1){
             $sqlUpdate = "UPDATE `user_table` SET `isBanned` = 0 WHERE `userId` = $id ";

        }
        
    mysqli_query( $GLOBALS['ligacao'], $sqlUpdate );

          
      }
                     
                    
   if(isset($_POST["submit"])){
       
       $id2 =$_POST["userId"];
      
      //echo($_POST["g2"]);
      //echo($_POST["g3"]);
      
      $sql = "UPDATE `user_table`\n"

    . "SET `auth_role_id` = '".$_POST["radio"]."'\n"

    . "WHERE `userId` = '".$id2."'";
       
       mysqli_query( $GLOBALS['ligacao'], $sql );
   }
   
   
      
      
      
   
   
  
    
?>




<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Restaurant Name</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="assets/img/icon.png" rel="icon">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,600,600i,700,700i|Satisfy|Comic+Neue:300,300i,400,400i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">


  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="assets/css/user.css?v=<?php echo time(); ?>">
  <style>
          
          .red-color {
            color:red;
            font-size: 42px;
            
          }
          .fa { 
              background-color:#ffc56e;
            
          }
          
      
          .bts{
              border: none;
              background-color:#ffc56e;
          }
          .green-color{
               color:green;
               font-size: 42px;
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
          
                      <?php  
          if ($userType == 2){
              
              ?>
                <li class="active"><a href="user.php">Profile</a></li>
              <?php
          }
          
          else if ($userType == 3){
              
              ?>
                <li><a href="user.php">Profile</a></li>
                <li><a href="AddRestaurant.php">Add restaurant</a></li>
              <?php
              
          }
          
           else if ($userType == 4){
              
              ?>
                <li><a href="user.php">Profile</a></li>
                <li><a href="AddRestaurant.php">Add restaurant</a></li>
                <li class="active"><a href="block_users.php">Block Users</a></li>
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
            
           if ($userType ==4){
           
           
           ?>
           
           
           <h1> Manage <span>Users</span> </h1>
           <br>
           
           <div class="row no-gutters">   
           
           
           <?php
           
            $querySql = "SELECT `name`,`isBanned`,`userId`,`name_role`,`auth_role_id` from `user_table` inner join `auth_role` on `auth_role_id` = `id` ";
            
            $insert = mysqli_query( $GLOBALS['ligacao'], $querySql );
            
              while ($row = $insert->fetch_assoc()) {
                            
                $banned=$row['isBanned'];
                $nameUser=$row['name'];
                $role=$row['auth_role_id'];
                $nameRole = $row['name_role'];
                $userId = $row['userId'];
                
 
  
           ?>
           
           
            <div class="card">

               
     <h4 class="card-title"><?= $nameUser ?>  </h4> 
     <img class="card-img-top5" src="data:image/png;base64,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" alt="Card image cap">

     <div class="card-block" style="background-color:#FFC56E">
       
      


 <p class="card-text">
              
    <p class="card-text">
      <light class="text-muted"><?=$nameRole?></light>
       </p>

       

        <form method="post" name="postRating">

       <input type="hidden" name="userId" value="<?=$userId?>">
       
       <?php
       
   
       
       if ($banned==0){
           
           ?>
     <button type="submit" name="submit_block_unblock" class="bts" ><i class="fa fa-check green-color"   ></i></button>

       
           <?php
           
       }
        else{
            
            ?>
     <button type="submit" name="submit_block_unblock" class="bts" ><i class="fa fa fa-ban red-color"  ></i></button>

       
           <?php
         
       }

       ?>

     <br>
     
      
       
       <div style="background-color:whitesmoke;">
        <input type="radio" id="user" name="radio" value="2">
         <br>
        <label for="user">User</label>
        <br>
        <input type="radio" id="sympathizer" name="radio" value="3">
         <br>
        <label for="sympathizer">Sympathizer</label>
        <br>
         <input type="radio" id="administrator" name="radio" value="4">
          <br>
        <label for="administrator">Administrator</label>
    </div>
     <input type="submit" name="submit" id="submit"  class="btn btn-primary" value="Save"/>
        </form>
           </div>
          

    </div>
               &nbsp;&nbsp;           
               <?php 
           }
           
       
 ?>
   </div>   
      
           
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
  
  
         <!-- ======= Footer ======= -->
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