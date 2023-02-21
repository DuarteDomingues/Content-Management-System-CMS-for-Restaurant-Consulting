<!DOCTYPE html>


<?php
    //session_destroy();
    require_once( "../Lib/lib.php" );
     require_once( "../Lib/db.php" );
    
    
    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    
     if( isset($_POST["submit"])){
        
         
         $username = $_POST['username'];
         $password = $_POST['password'];
         
         
         //$insertQuery = "SELECT userId, name, auth_role_id, isBanned FROM `smi`.`user_table` WHERE isActive=1 AND name ='$username' AND password ='$password' LIMIT 1";
         $insertQuery = "SELECT * FROM `smi`.`user_table` WHERE name ='".$username."' AND password ='".$password."' LIMIT 1";
         $insert=mysqli_query( $GLOBALS['ligacao'], $insertQuery );
         
          if($insert->num_rows==1){
              
              while($row = $insert->fetch_assoc()) {
                  
                  $isActive=$row["isActive"];
                  $isBanned=$row["isBanned"];
                  
                  if($isActive==1 && $isBanned==0){
                      
                  if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
                       
                 $_SESSION["userId"] = $row["userId"];
                 $_SESSION["authRoleId"] = $row["auth_role_id"];
                 $_SESSION["name"] = $row["name"];
                 $_SESSION["isBanned"] =$isBanned;
                 
                  header("Location: http://localhost/examples-smi/Projecto/index.php");
                  exit();
                  
                  }
                  else{

                        echo '<script>alert("Account is not active or banned")</script>';
                  }
                  
                 }
                  

                 
              
              
             
          }else{
              echo '<script>alert("Username or password invalid")</script>';
             
             
          }
     }
    
    
    ?>


<html>
    <head>
      
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>

             <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="assets/img/icon.png" rel="icon">
  
  
    <!-- Template Main CSS File -->
 
  <link rel="stylesheet" href="assets/css/user.css?v=<?php echo time(); ?>">


    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,600,600i,700,700i|Satisfy|Comic+Neue:300,300i,400,400i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">

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
    

          <li class="book-a-table text-center"><a href="TemplateLogIn.php">Login</a></li>

        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header>
   <main id="main">

       <section class="inner-page">
        <div class="main">
            <section class="signup">
                <div class="container">
                    <div class="signup-content">
                        <form method="POST" id="signup-form" name="myform" class="signup-form" onsubmit="">
                            <h2 class="form-title">Login</h2>
                             &nbsp;
                            <div class="form-group">
                                <input type="text" class="form-input input-lg " required name="username" id="username" placeholder="Username"/>
                            </div>
                            <div class="form-group">
                                <input type="password" required class="form-input input-lg "  name="password" id="password"  placeholder="Password"/>
                            </div>

                            <div class="form-group">
                                <div class="">
                                    <div class="g-recaptcha"  data-sitekey="6LdKRacZAAAAAJdnGKbHbk7NsRWm9hKyjMhPWmGk"></div>
                                </div>
                            </div>
 &nbsp;
                            <div class="form-group_2">
                                <input type="submit" name="submit" id="submit" type="button" class="btn btn-primary"  value="Login"/>
                            </div>
                            <p id="invalid" class="invalid" style="font-size: 16px;"/>
                        </form>
                        <p class="loginhere">
                            Don't have an account yet ?
                            <a href="TemplateRegister.php" class="loginhere-link">Register here</a>
                        </p>
                    </div>
                </div>
            </section>
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
