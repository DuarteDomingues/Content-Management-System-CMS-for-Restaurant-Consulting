<!DOCTYPE html>
<?php

    session_start();
     require_once( "../Lib/lib.php" );
     require_once( "../Lib/db.php" );
    
    
    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    
    //$captchaInput= $_SESSION['captcha'];
    //echo($captchaInput);
    
    
    if( isset($_POST["submit"])){
        
        if($_SESSION['captcha'] == $_POST['captcha']){
        
       
      
        
        
        $username = $_POST['username'];
        $gender = $_POST['gender'];
        $birthday_input = $_POST['birthday'];
        $birthday=date("Y-m-d H:i:s",strtotime($birthday_input));
        
        
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hash = md5(time().$username);
  
        $active = 0;
         
         
         $date = "2012-08-06";
         $date=date("Y-m-d",strtotime($date));
         
         /*$insertQuery = "INSERT INTO `user_table2`( `auth_role_id`, `name`, `password`, `nationality`, `birthdate`, `gender`, `email`, `user_hash`, `isActive`)
                 VALUES (1,'Certo','pass','bronzil','000000',1,'@email.com','10000',0)";*/
         
          $insertQuery = "INSERT INTO `user_table`( `auth_role_id`, `name`, `password`, `nationality`, `birthdate`, `gender`, `email`, `user_hash`, `isActive`,`isBanned`)
                 VALUES (2,'".$username."','".$password."','Portugal','".$birthday_input."',1,'".$email."','".$hash."',0,0)";

        
         $insert=mysqli_query( $GLOBALS['ligacao'], $insertQuery );
         
       
       if($insert){
        echo("Check email for account activation");
        
        
        $to      = $email; // Send email to our user
        $subject = 'Signup | Verification'; // Give the email a subject 
        $message = '
  
        Thanks for signing up!
        Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
  
        ------------------------
        Username: '.$username.'
        Password: '.$password.'
        ------------------------
  
        Please click this link to activate your account:
        http://localhost/examples-smi/Projecto/verifyRegist.php?hash='.$hash.'
        
  
        '; // Our message above including the link
                      
        $headers = 'From: miguelafonsosilvestre725@gmail.com' . "\r\n"; // Set from headers
        mail($to, $subject, $message,$headers); // Send our email
        //mail('miguelafonsosilvestre725@gmail.com','joao pecados','Boas joao pecados acbou de ganhar 1 dildo','From: miguelafonsosilvestre725@gmail.com');
        
       }else{
        echo("Username or email alredy exists");
        echo '<script>alert("Username or email alredy exists")</script>';
       }
        
    }
    else{
        echo("Erro captcha, Try again!");
        echo '<script>alert("Erro captcha, Try again!")</script>';
    }
    }
    /*
     if(isset($_SESSION['msg'])){
                echo $_SESSION['msg'];
                unset ($_SESSION['msg']);
            }
     * 
     * 
     * 
     * <span style="color: red !important; display: inline; float: none;">*</span> 
*/

  
?>


<html>
    <head>
     
       
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
              <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>

             <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login</title>
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
        
        
        
      <script type="text/javascript" src="js/validator.js"> </script>
      <script>

  
     var email_validation = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
     var password_validation = /^(?=.*[A-Z]).{8,}$/;
     

         </script>
           <link rel="stylesheet" href="assets/css/user.css?v=<?php echo time(); ?>">

    </head>
    <body>
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
                        <form method="POST" id="signup-form" class="signup-form" onsubmit="return FormRegistValidator(this, email_validation ,password_validation )" name="FormRegist">
                            <h2 class="form-title">Create <span>account</span></h2>
                                 &nbsp;
                                 <p>
                            
                            <div class="form-group">
                                <span style="color: red !important; display: inline; float: none;">*</span> 
                                <input type="text" class="form-input input-lg" name="username" id="username" placeholder="Username" required/>
                                
                            </div>
                            
                    
                            
                            <div class="form-group">
                                <span style="color: red !important; display: inline; float: none;">*</span> 
                                <input type="email" class="form-input input-lg" name="email" id="email"  placeholder="Your Email" required/>
                            </div>
                            
                            <div class="form-group">
                                <span style="color: red !important; display: inline; float: none;">*</span> 
                                <input type="password" class="form-input input-lg"  name="password" id="password"  placeholder="Password" required/>
                            </div>
                            
                             <div class="form-group">
                                 <span style="color: red !important; display: inline; float: none;">*</span> 
                                <input type="password" class="form-input input-lg"  name="password_confirm" id="password_confirm"  placeholder="Password Confirm" required/>
                            </div>
                                 
                                         <div class="form-group">
                                             <span style="color: red !important; display: inline; float: none;">*</span> 
                                             <label  for="gender" >Gender: </label>
                                <select id="gender" class="form-input input-sm " name="gender" required>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                  
                                </select>
                            </div>
                            
                               &nbsp;
                            <div class="form-group">
                                <span style="color: red !important; display: inline; float: none;">*</span> 
                                <label > Age: </label>
                                <p>
                                <input type="date" class="md-form md-outline" inline="true" name="birthday" id="birthday" required>
                            </div>
                                 
                                 
                            
                               &nbsp;
                            
                            <div class="form-group">
                                <img src="captcha.php" alt="Captcha code" >
                            </div>    
                             <div class="form-group">
                                                                 <span style="color: red !important; display: inline; float: none;">*</span> 

                                <input type="text" name="captcha" class="form-input input-lg"    placeholder="Type your captcha" required>
                            </div>    
                               &nbsp;
                            <div class="form-group_2">
                                <input type="submit" name="submit" id="submit"  class="btn btn-primary" value="Sign up"/>
                            </div>

                            <p id="invalid" class="invalid" style="font-size: 16px;"/>
                        </form>
                        <p class="loginhere">
                            Already have an account ?
                            <a href="TemplateLogIn.php" class="loginhere-link">Login here</a>
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


