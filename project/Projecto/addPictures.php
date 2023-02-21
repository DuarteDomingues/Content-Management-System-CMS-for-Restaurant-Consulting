<?php
session_start();

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






<!DOCTYPE html>

<html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Add Restaurant Pictures</title>
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
         <link rel="stylesheet" href="assets/css/user.css?v=<?php echo time(); ?>">
       
</head>
<body>
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
          if ($login == 1){
              
              ?>
                <li><a href="user.php">Profile</a></li>
                <li><a href="AddRestaurant.php">Add Restaurant</a></li>
              <?php
          }
          
          
          ?>
  

                <li class="book-a-table text-center">
              
              <?php   
              
              if ($login == 0){
                  ?>
               <a href=<?=$homeLink?><?= $login_logout_str ?></a>

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
                <div class="container">
    <form  method="post" enctype="multipart/form-data">
    Select more restaurants pictures:
    <input type="file" name="files[]" multiple >
    <br>
    <input type="submit" name="submit" value="UPLOAD">
    
    </form>
                    &nbsp;
                    <br>
                </div>
              
               <div class="container">
              <div class="row no-gutters">

         

         
         

          
  
    



<?php
    /*
    require_once( "C:/Users/pedro/OneDrive/Ambiente de Trabalho/SMI/Exemplos/PHP/Lib/lib.php" );
    require_once( "C:/Users/pedro/OneDrive/Ambiente de Trabalho/SMI/Exemplos/PHP/Lib/db.php" );
    
    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    
    $path="C:/Users/pedro/OneDrive/Ambiente de Trabalho/SMI/Exemplos/PHP/Projecto/uploads";
    $userName="Chucky";
    $fullPath=$path . "/" . $userName;
            
            
    
    if( isset($_POST["submit"])){
        
        $image=$_POST["uploadfile"];
        echo($image);
        if (!file_exists($fullPath)) {
        mkdir($fullPath, 0777, true);
        }
        copy($path."/".$image, $fullPath."/".$image);
        $pathDB=$userName."/".$image;
        
        //inserir pictures
         $insertQuery = "INSERT INTO `restaurant_pictures`(`restaurant_id` ,`path_image`)
                 VALUES (5,'".$pathDB."')";

         $insert=mysqli_query( $GLOBALS['ligacao'], $insertQuery );
    }
    */
    ########################################################################################
  require_once( "../Lib/lib.php" );
   require_once( "../Lib/db.php" );
    
    
  
            
    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    
    $restaurantId = $_SESSION['restaurantId'];
   
    
    if(isset($_POST['submit'])){ 
    // File upload configuration 
    $targetDir = "uploads/"; 
    $allowTypes = array('jpg','png','jpeg','gif','jfif'); 
     
    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = ''; 
    $fileNames = array_filter($_FILES['files']['name']); 
    if(!empty($fileNames)){ 
        foreach($_FILES['files']['name'] as $key=>$val){ 
            // File upload path 
            $fileName = basename($_FILES['files']['name'][$key]); 
            $targetFilePath = $targetDir . $fileName; 
             
            // Check whether file type is valid 
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
            if(in_array($fileType, $allowTypes)){ 
                
                    $path="C:/Users/pedro/OneDrive/Ambiente de Trabalho/SMI/Exemplos/PHP/Projecto/uploads";
                    $fullPath=$path . "/" . $userName;
        
                    if (!file_exists($fullPath)) {
                        mkdir($fullPath, 0777, true);
                    }
                    copy($path."/".$fileName, $fullPath."/".$fileName);
                    $pathDB=$userName."/".$fileName;
                    
                    $insertQuery = "INSERT INTO `restaurant_pictures`(`restaurant_id` ,`path_image`)
                    VALUES ('".$restaurantId."','".$pathDB."')";
                    $insert=mysqli_query( $GLOBALS['ligacao'], $insertQuery );
                    
            }else{ 
                echo '<script>alert("File type invalid")</script>';
            } 
           
        } 
          
        
    }
    
    $sql = "SELECT `path_image` FROM `restaurant_pictures` WHERE `restaurant_id` = '".$restaurantId."'";
    $result  = mysqli_query( $GLOBALS['ligacao'], $sql );
      
      $images=array();
      while ($row = $result->fetch_assoc()) {
        $image = $row['path_image'];
        //echo($image);
        //array_push($images, $image);
        ?>
         <img src="<?php echo "uploads/".$image; ?>" alt="" width="250" height="180"/>
         &nbsp;
         <br>
         
          
        <?php
      }
    
     
} 
?>
        </div>
              </div>
          </section>
    </main>
</body>
</html>