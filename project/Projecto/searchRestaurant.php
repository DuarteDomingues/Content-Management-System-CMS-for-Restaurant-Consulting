<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

   require_once( "../Lib/lib.php" );
   require_once( "../Lib/db.php" );
    
    
  
            
    dbConnect( ConfigFile );
    $dataBaseName = $GLOBALS['configDataBase']->db;
    mysqli_select_db( $GLOBALS['ligacao'], $dataBaseName );
    
    
    
 if(isset($_POST["submit"])){
     
     $resNameIn=$_POST['name'];
     $resLocalIn=$_POST['local'];
    
    #restaurante name 
    $sqlName = "SELECT *  FROM `restaurant` WHERE `name` LIKE '$resNameIn%' ORDER BY `id` ASC";
    
    #restaurante tipo
    #$sql = "Select `restaurant_id` from restaurant_type INNER JOIN type ON restaurant_type.type_id = type.id Where type.name_type LIKE '$resNameIn%'";
    
     $resultName = mysqli_query( $GLOBALS['ligacao'], $sqlName );
     
     while ($row = $resultName->fetch_assoc()) {
        #echo($row['restaurant_id']);
         echo($row['id']);
        echo("<br>");
        
     }
    echo("#############################################<br>");
    #restaurante local
    $sqlLocal = "SELECT `idRestaurant`  FROM `restaurant_location` WHERE `City` LIKE '$resLocalIn%'";
    
    $resultLocal = mysqli_query( $GLOBALS['ligacao'], $sqlLocal );
    
    
     while ($row = $resultLocal->fetch_assoc()) {
        #echo($row['restaurant_id']);
         echo($row['idRestaurant']);
        echo("<br>");
        
     }
 }

?>

<!DOCTYPE html>
<html>
<body>


<form method="POST" name="myform">
    
        <input type="text" name="local" id="local" placeholder="local" required/>
        <input type="text" name="name" id="name" placeholder="name" required/>
        <input type="submit" name="submit" id="submit" value="Search"/>
     
    
</form>

</body>
</html>