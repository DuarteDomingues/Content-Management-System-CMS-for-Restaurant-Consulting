<?php
session_start();


include 'getuserInfo.php';

$homeLink = "TemplateLogIn.php";

$login = 0;
$userType = 0;
$user_id  = 0;

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
            $user_id  = $_SESSION['userId'];
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
  

    require_once( "../Lib/lib.php" );
     require_once( "../Lib/db.php" );
    
    require_once("getUserInfo.php");
    


    
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Restaurants Search</title>
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
  
  
  
  <script type='text/javascript'>
            
            
        $(document).ready(function() {
            var max_fields = 10;
            var wrapper = $(".container1");
            var add_button = $(".add_form_field");

            var x = 0;
            $(add_button).click(function(e) {
                e.preventDefault();
                if (x < max_fields) {
                x++;
                $(wrapper).append('<p><div><input type="text" name="name'+x+'"  class="selectStuff" placeholder="type '+x+'" required/><a href="#" class="delete">&nbsp;Delete</a></div><p>'); //add input box
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
        </script>
        
                                <?php
            if(isset($_POST["submit"])){
        
          
            
            $addTypes= array();
            
            $numberTypes= $_POST['test'];
            //echo($numberTypes);
            echo("<br>");
            
            if($numberTypes>0){
                  for ($x = 1; $x <= $numberTypes; $x++) {
                 
                 $types=$_POST['name'.$x];
                 //echo($types);
                 //echo("<br>");
                 array_push($addTypes,$types);
                 
            
            }
                
            }
         
                
                foreach ($addTypes as $value) {
                     //echo($value);
                     //echo("<br>");
                     #$sql = "INSERT INTO `type`(`name_type`) VALUES ola";
                     $sql = "INSERT INTO `type`( `name_type`) VALUES ('".$value."')";
                     $result  = mysqli_query( $GLOBALS['ligacao'], $sql );
                    
                }
             
                
               
            }
  
  ?>
        
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
                <li><a href="user.php">Profile</a></li>
                <li><a href="AddRestaurant.php">Add restaurant</a></li>
              <?php
              
          }
          
           else if ($userType == 4){
              
              ?>
                <li><a href="user.php">Profile</a></li>
                <li><a href="AddRestaurant.php">Add restaurant</a></li>
                <li ><a href="block_users.php">Block Users</a></li>
                <li class="active"><a href="addTypes.php">Add Types</a></li>
                
                
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
           
           if ($userType == 4)
           {
           ?>
           
           
           
           <section class="signup">
                <div class="container">
                    <div class="signup-content">
                        <form method="POST" id="signup-form" name="myform" class="signup-form">
                            
                            <h2 class="form-title">Add <span>Types</span></h2>
                            &nbsp;
                            
                            
                            
                             <div><input type="hidden" name="test" id= "test" value="0"></div>
                            
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                            
                            <div class="container1">
                                <button class="add_form_field" style="font-size: 13px">Add new type 
                                    
                                <span style="font-size:16px; font-weight:bold;">&nbsp;+ &nbsp; </span>
                                </button>
                                <p>
                                    <div>
                                    <?php
                                    //obter restaurant info
                                    $sql = "SELECT * FROM `type`";
                                    $result  = mysqli_query( $GLOBALS['ligacao'], $sql );
    
                                    $index=0;
                                    while ($row = $result->fetch_assoc()) {
                                        $type=$row['name_type'];
                                        //echo($row['name_type']);
                                        $index++;
                                    ?>
                                <input type="text" name="<?php echo "myname".$index ?>" class="selectStuff" value="<?php echo $type?>" readonly>
                                 <?php
                                    }
                                    
                                  ?>
                                </div>
                                
                               
                            </div>
                            </br>
                             <div class="form-group">
                                <input type="submit" name="submit" id="submit"  class="btn btn-primary" value="Add"/>
                             </div>
                                
                            
                             </form>

                       
                    </div>
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
  
  
   &nbsp; &nbsp;
   
   <div class="kappa"style="color:white">
       <h1>kappa</h1>
         <h1>kappa</h1>

  
   </div>
   

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

