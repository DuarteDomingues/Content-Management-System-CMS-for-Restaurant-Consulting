<!DOCTYPE html>
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
  
   require_once( "../Lib/lib.php" );
   require_once( "../Lib/db.php" );
    
    
    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    
    $resId=10;
    
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
     
     for ($index = 0; $index < count($tiposId); $index++) {
         
     $sql = "SELECT `name_type` FROM `type` WHERE `id` = '".$tiposId[$index]."'";
     $result  = mysqli_query( $GLOBALS['ligacao'], $sql );
     while ($row = $result->fetch_assoc()) {
         //echo( $row['name_type']);
         $tiposName=$tiposName.", ".$row['name_type'];
         //array_push($tiposName, $row['name_type']);
     }
     
    }
    $tiposName=ltrim($tiposName, $tiposName[0]);
            
     
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

       <div class="card " style="width: 66rem; height: 66rem;" >
           <p>
                 <h1 class="card-title"><?=$resName ?></h1>
  <img
      src="<?=$resPhoto; ?>"
      
      class="img-fluid"    alt="..."
    
  />
  <div class="card-body" >
    <p class="card-text">
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
    <li class="list-group-item">Rating</li>
  </ul>
    
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
          <p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>
        </div>
          <p>

        <div class="row no-gutters">

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-1.jpg" class="venobox" data-gall="gallery-item">
                <img src="assets/img/gallery/gallery-1.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-2.jpg" class="venobox" data-gall="gallery-item">
                <img src="assets/img/gallery/gallery-2.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-3.jpg" class="venobox" data-gall="gallery-item">
                <img src="assets/img/gallery/gallery-3.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-4.jpg" class="venobox" data-gall="gallery-item">
                <img src="assets/img/gallery/gallery-4.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-5.jpg" class="venobox" data-gall="gallery-item">
                <img src="assets/img/gallery/gallery-5.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-6.jpg" class="venobox" data-gall="gallery-item">
                <img src="assets/img/gallery/gallery-6.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-7.jpg" class="venobox" data-gall="gallery-item">
                <img src="assets/img/gallery/gallery-7.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item">
              <a href="assets/img/gallery/gallery-8.jpg" class="venobox" data-gall="gallery-item">
                <img src="assets/img/gallery/gallery-8.jpg" alt="" class="img-fluid">
              </a>
            </div>
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
          <p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>
        
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
              <p>Every Day:<br><?=$resOpenTime ?> - <?=$resCloseTime ?></p>
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

    <div class="card-deck">
        <div class="card">
            <p>
            <h4 class="card-title">Sushi1</h4>

            <img class="card-img-top" src="assets/img/sushi.jpg" alt="Card image cap">
            <div class="card-block">

                <p class="card-text">
              
          <a href="#" class="stretched-link"></a>
           <p class="card-text">
             <small class="text-muted">R. do Pombal 10, 2005-395 Vale de Santarém</small>
                  </p>
    
                     <ul class="list-group list-group-flush">
             <li class="list-group-item">Rating</li>
             </ul>
            </div>
        </div>
  
          <div class="card">
                 <p>
            <h4 class="card-title">Sushi2</h4>

            <img class="card-img-top" src="assets/img/sushi.jpg" alt="Card image cap">
            <div class="card-block">

                <p class="card-text">
              
          <a href="#" class="stretched-link"></a>
           <p class="card-text">
             <small class="text-muted">R. do Pombal 10, 2005-395 Vale de Santarém</small>
                  </p>
    
                     <ul class="list-group list-group-flush">
             <li class="list-group-item">Rating</li>
             </ul>
            </div>
        </div>
  
             <div class="card">
                 <p>
            <h4 class="card-title">Sushi3</h4>

            <img class="card-img-top" src="assets/img/sushi.jpg" alt="Card image cap">
            <div class="card-block">

                <p class="card-text">
              
          <a href="#" class="stretched-link"></a>
           <p class="card-text">
             <small class="text-muted">R. do Pombal 10, 2005-395 Vale de Santarém</small>
                  </p>
    
                     <ul class="list-group list-group-flush">
             <li class="list-group-item">Rating</li>
             </ul>
            </div>
        </div>
   
    </div>
         
           &nbsp;
           <p>
       <h1> Reviews </h1>
         &nbsp;   
         
         <div class="container">
	
	<div class="card">
	    <div class="card-body">
	        <div class="row">
        	    <div class="col-md-2">
        	        <img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid"/>
        	        <p class="text-secondary text-center">15 Minutes Ago</p>
        	    </div>
        	    <div class="col-md-10">
        	        <p>
        	            <a class="float-left" href="https://maniruzzaman-akash.blogspot.com/p/contact.html"><strong>Maniruzzaman Akash</strong></a>
        	            <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                        <span class="float-right"><i class="text-warning fa fa-star"></i></span>
        	            <span class="float-right"><i class="text-warning fa fa-star"></i></span>
        	            <span class="float-right"><i class="text-warning fa fa-star"></i></span>

        	       </p>
        	       <div class="clearfix"></div>
        	        <p>Lorem Ipsum is simply dummy text of the pr make  but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        	        <p>
        	            <a class="float-right btn text-white btn-danger"> <i class="fa fa-heart"></i> Like</a>
        	       </p>
        	    </div>
	        </div>
	        	
            
	            </div>
	    </div>
</div>
         
         
         
         
    </div>
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