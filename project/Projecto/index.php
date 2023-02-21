<!DOCTYPE html>
<?php
session_start();

$homeLink = "TemplateLogIn.php";

$login = 0;
$userName = "";
$userType = 0;


require_once( "../Lib/lib.php" );
require_once( "../Lib/db.php" );
require_once( "getUserInfo.php" );

  

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

    
  
            
    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    
    

  
  
  
    $sqlTodasLocal = "SELECT `City` FROM `restaurant_location` WHERE 1";

     $resultTodasLocal = mysqli_query( $GLOBALS['ligacao'], $sqlTodasLocal );
     $arrayTodasLocal=array();
     
      while ($row = $resultTodasLocal->fetch_assoc()) {

         array_push($arrayTodasLocal,$row['City']);
         
      }
      
      $arrayTodasLocal=array_unique($arrayTodasLocal);
      

      $sqlTodosRes = "SELECT  `name` FROM `restaurant`";
      $resultTodasRes = mysqli_query( $GLOBALS['ligacao'], $sqlTodosRes );
      
      $arrayRes=array();
      
      while ($row = $resultTodasRes->fetch_assoc()) {

          
         array_push($arrayRes,$row['name']);
         
      }
      
      
      $sqlTodosTipos= "SELECT  `name_type` FROM `type`";
      $resultTodosTipos = mysqli_query( $GLOBALS['ligacao'], $sqlTodosTipos );
      
      
      while ($row = $resultTodosTipos->fetch_assoc()) {
 
          
         array_push($arrayRes,$row['name_type']);
         
      }
      
   
      if(isset($_POST["submit"])){
          
           $resNameIn=$_POST['name'];
           $resLocalIn=$_POST['myCountry'];
           
           $arraySearchRes=array();
          

           if ($resNameIn!=="" &&  ($resLocalIn==="")){
                              
    $sqlName = "SELECT *  FROM `restaurant` WHERE `name` LIKE '$resNameIn%' ORDER BY `id` ASC";
    
    #restaurante tipo
    #$sql = "Select `restaurant_id` from restaurant_type INNER JOIN type ON restaurant_type.type_id = type.id Where type.name_type LIKE '$resNameIn%'";
    
     $resultName = mysqli_query( $GLOBALS['ligacao'], $sqlName );
     
     while ($row = $resultName->fetch_assoc()) {
        #echo($row['restaurant_id']);

        echo($row['id']);
        echo("<br>");
        array_push($arraySearchRes, $row['id']);
    
     }
   $sqlType = "Select `restaurant_id` from restaurant_type INNER JOIN type ON restaurant_type.type_id = type.id Where type.name_type LIKE '$resNameIn%'";
    $resultType = mysqli_query( $GLOBALS['ligacao'], $sqlType );
     
     while ($row = $resultType->fetch_assoc()) {
        echo($row['restaurant_id']);

       # echo($row['id']);
        echo("<br>");
        array_push($arraySearchRes, $row['restaurant_id']);
    
     }
   
   
  }
      if ($resLocalIn!=="" &&  ($resNameIn==="")) {
          

              #restaurante local
    $sqlLocal = "SELECT `idRestaurant`  FROM `restaurant_location` WHERE `City` LIKE '$resLocalIn%'";
    
    $resultLocal = mysqli_query( $GLOBALS['ligacao'], $sqlLocal );
    
    
     while ($row = $resultLocal->fetch_assoc()) {
        #echo($row['restaurant_id']);
         echo($row['idRestaurant']);
        echo("<br>");
        array_push($arraySearchRes,$row['idRestaurant']);
        
        
       }   
   
     }    
     
     else if($resLocalIn!=="" &&  ($resNameIn!=="")){
         
    $sql = "SELECT * FROM `restaurant` inner join `restaurant_location` on `restaurant`.`id` = `restaurant_location`.`idRestaurant` where `restaurant`.`name` LIKE '$resNameIn%' and `restaurant_location`.`City` LIKE '$resLocalIn%'";
    
    $resultLocalName = mysqli_query( $GLOBALS['ligacao'], $sql );
    
     while ($row = $resultLocalName->fetch_assoc()) {
        #echo($row['restaurant_id']);
         echo($row['idRestaurant']);
         echo("<br>");
         array_push($arraySearchRes,$row['idRestaurant']);
        
       }   
$sqlTypeLocal = "select * from `restaurant_location` inner JOIN \n"

    . "`restaurant_type` on `restaurant_location`.`idRestaurant`\n"

    . "= `restaurant_type`.`restaurant_id`\n"

    . "inner join `type` on `restaurant_type`.`type_id`=`type`.`id`\n"

    . "where `City` LIKE '$resLocalIn%' and `name_type` like '$resNameIn%'";
       
        $resultTypeLocal = mysqli_query( $GLOBALS['ligacao'], $sqlTypeLocal );
    
     while ($row = $resultTypeLocal->fetch_assoc()) {
        #echo($row['restaurant_id']);
        echo($row['idRestaurant']);
        echo("<br>");
        array_push($arraySearchRes,$row['idRestaurant']);
        
       }   
       
         }
         $arraySearchRes = array_unique($arraySearchRes);
         
         
      
         
         
         $_SESSION['searchRestaurants'] = $arraySearchRes;
       
         
         
         
         header("Location: collections.php");
         exit();
         
         
      
    }
            
  
  
  
  
  
  

  

?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Home</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="assets/img/icon.png" rel="icon">


  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,600,600i,700,700i|Satisfy|Comic+Neue:300,300i,400,400i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">


  <!-- Template Main CSS File -->

    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo time(); ?>">
    <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    
    <style>


/*the container must be positioned relative:*/
.autocomplete {
  position: relative;
  display: inline-block;
}

input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}



.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
</style>
    
    
    
    <script src="http://code.jquery.com/jquery-latest.js"></script>

 
    
    
<script>


function SubmitFormData() {
    var name = $("#myInput").val();
    $.post("autoCompleteRes.php", { name: name},
    function(data) {
	 $('#results').html(data);
	 //$('#foo')[0].reset();
    });
    
   
    
}




</script>





 
</head>

<body>

  <!-- ======= Top Bar ======= -->
  <section id="topbar" class="d-none d-lg-flex align-items-center">
    <div class="container text-right">
      <i class="icofont-phone"></i> +1 351 937050860

    </div>
  </section>

  <!-- ======= Header ======= -->
  <header id="header" class="  d-flex align-items-center header-transparent">
    <div class="container d-flex align-items-center">

      <div class="logo mr-auto">
        <h1 ><a href="index.php">ChuckYummy</a></h1>
              <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        
      </div>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li><a href="about.php">ABOUT</a></li>
          
          <?php  
          if ($userType == 2){
              
              ?>
                <li><a href="user.php">PROFILE</a></li>
              <?php
          }
          
          else if ($userType == 3){
              
              ?>
                <li><a href="user.php">PROFILE</a></li>
                <li><a href="AddRestaurant.php">ADD RESTAURANT</a></li>
              <?php
              
          }
          
           else if ($userType == 4){
              
              ?>
                <li><a href="user.php">PROFILE</a></li>
                <li><a href="AddRestaurant.php">ADD RESTAURANT</a></li>
                <li><a href="block_users.php">BLOCK USERS</a></li>
                <li><a href="addTypes.php">ADD TYPES</a></li>
                
                
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
  
  
  
  
  
  <main>
  <!-- ======= Hero Section ======= -->
  <section id="hero">
 
<div class="hero-container">
      <div id="heroCarousel" class="carousel slide carousel-fade" data-ride="carousel">

        <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>


            <div class="carousel-item active" style="background: url(assets/img/slide/slide-1.jpg);">
            <div class="carousel-container">
              <div class="carousel-content">
                   <div class="container">         
                <p>
                      
                 </p>
              <h2 class="animate__animated animate__fadeInDown"> Find the best restaurants</h2>
              
              <section class="search-sec">
    <div class="container">
        <form autocomplete="off" id="foo" method="POST">
            <div class="autocomplete">
            
            <div class="row">
                <div class="col-lg-14">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                            <input id="myInput" type="text" class="form-control search-slt" name="myCountry" placeholder="Enter a location">
                        </div>
                         <div class="col-lg-2 col-md-3 col-sm-12 p-0">
                  <input type="button" id="submitFormData" class="btn btn-danger wrn-btn" name="submit" onclick="SubmitFormData()" value="save local">
                    
                      </div>  
                        <h1 style="visibility: hidden;"> k</h1>
                        
                        <div class="col-lg-3 col-md-3 col-sm-15 p-0">
                            <input id="myInputName" type="text" class="form-control search-slt" name="name" placeholder="Enter Restuarant, food, city...">
                                 <input id="local" type="hidden" name="local" >
                        </div>
                        
                        <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                  <input type="submit" id="button_2" class="btn btn-danger wrn-btn" name="submit" >
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </form>
        
           <div id="results">
   <!-- All data will display here  -->
   </div>


    </div>
</section>

            </div>
          </div>

      </div>
    </div>
</section>
  </main>
  
   
  
  
   <section id="about" class="about">
      <div class="container-fluid">

        <div class="row">

          <div class="col-lg-5 align-items-stretch video-box" style='background-image: url("assets/img/about.jpg");'>
           
          </div>

          <div class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch">

            <div class="content">
              <h3>We are dedicated to our users <strong>Quality is our number one concern</strong></h3>
            
              <p class="font-italic">
                We have connections with hundred of restaurants in several citys
              </p>
              <ul>
                <li><i class="bx bx-check-double"></i> We focus on our costumers</li>
                <li><i class="bx bx-check-double"></i> We care about our users more than anyone</li>
              </ul>
              <p>
                Hundreds of or users have enjoyed our service, several of restaurants work with ChuckYummy
              </p>
            </div>

          </div>

        </div>

      </div>
    </section>
  
  
  
  
  
  
&nbsp;
<p>
<p>
<span style="padding-left:80px"> 

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




<script >
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}



/*An array containing all the country names in the world:*/
//var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
var cities = <?php echo '["' . implode('", "', $arrayTodasLocal) . '"]' ?>;
var res = <?php echo '["' . implode('", "', $arrayRes) . '"]' ?>;

//var res



/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("myInput"), cities);
autocomplete(document.getElementById("myInputName"), res);
</script>




</body>
</html>